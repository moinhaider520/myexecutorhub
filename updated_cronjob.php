<?php
// require 'db_connection.php';

// Choose the appropriate database configuration based on the environment
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Local environment
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "my_executor_hub";
} else {
    // Live environment
    $servername = "localhost";
    $username = "u158483578_executorhub";
    $password = "My_Executor_Hub_123";
    $database = "u158483578_executorhub";
}

// Create a connection
$mysqli = new mysqli($servername, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


// Fetch all subscribed users on recurring Stripe subscriptions (exclude lifetime packages)
$sql = "SELECT id, stripe_subscription_id, subscribed_package 
        FROM users 
        WHERE stripe_subscription_id IS NOT NULL 
          AND (subscribed_package IS NULL OR subscribed_package NOT LIKE 'Lifetime%')";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userId = $row['id'];
        $subscribedPackage = $row['subscribed_package'];

        if ($subscribedPackage && stripos($subscribedPackage, 'Lifetime') !== false) {
            continue;
        }

        // -------------------------
        // 1. Update trial_ends_at
        // -------------------------
        $sqlUpdateAssociatedUsers = "UPDATE users 
                                     SET trial_ends_at = DATE_ADD(trial_ends_at, INTERVAL 30 DAY) 
                                     WHERE created_by = $userId";
        $mysqli->query($sqlUpdateAssociatedUsers);

        $sqlUpdateUser = "UPDATE users 
                          SET trial_ends_at = DATE_ADD(trial_ends_at, INTERVAL 30 DAY) 
                          WHERE id = $userId";
        $mysqli->query($sqlUpdateUser);

        // -------------------------
        // 2. Get plan amount
        // -------------------------
        $plans = [
            'Basic'    => 5.99,
            'Standard' => 11.99,
            'Premium'  => 19.99,
        ];
        $planAmount = $plans[$subscribedPackage] ?? 0;

        // -------------------------
        // 3. Find coupon owner
        // -------------------------
        $sqlCouponUsage = "SELECT partner_id FROM coupon_usages WHERE user_id = $userId LIMIT 1";
        $couponUsageRes = $mysqli->query($sqlCouponUsage);
        $couponUsage = $couponUsageRes->fetch_assoc();

        if ($couponUsage && $planAmount > 0) {
            $couponOwnerId = $couponUsage['partner_id'];

            // Check if this coupon owner has a parent in partner_relationships
            $sqlRelationship = "SELECT parent_partner_id FROM partner_relationships WHERE sub_partner_id = $couponOwnerId LIMIT 1";
            $relRes = $mysqli->query($sqlRelationship);
            $relationship = $relRes->fetch_assoc();

            if ($relationship) {
                // Sub-partner case
                $ownerCommission  = $planAmount * 0.30;
                $parentCommission = $planAmount * 0.20;
                $adminCommission  = $planAmount * 0.50;

                $mysqli->query("UPDATE users SET commission_amount = commission_amount + $ownerCommission WHERE id = $couponOwnerId");
                $mysqli->query("UPDATE users SET commission_amount = commission_amount + $parentCommission WHERE id = {$relationship['parent_partner_id']}");
                $mysqli->query("UPDATE users SET commission_amount = commission_amount + $adminCommission WHERE id = (SELECT id FROM users WHERE user_role = 'admin' LIMIT 1)");

            } else {
                // Original calculation (20% or 30%)
                $sqlCount = "SELECT COUNT(*) as total FROM coupon_usages WHERE partner_id = $couponOwnerId";
                $countRes = $mysqli->query($sqlCount);
                $countRow = $countRes->fetch_assoc();
                $affiliateCount = $countRow['total'];

                if ($affiliateCount <= 50) {
                    $commissionAmount = $planAmount * 0.20;
                } else {
                    $commissionAmount = $planAmount * 0.30;
                }

                $adminCommission = $planAmount - $commissionAmount;

                $mysqli->query("UPDATE users SET commission_amount = commission_amount + $commissionAmount WHERE id = $couponOwnerId");
                $mysqli->query("UPDATE users SET commission_amount = commission_amount + $adminCommission WHERE id = (SELECT id FROM users WHERE user_role = 'admin' LIMIT 1)");
            }
        }
    }
} else {
    echo "No users found with active subscriptions.\n";
}

?>