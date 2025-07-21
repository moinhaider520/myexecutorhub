<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\CouponUsage;
use App\Notifications\WelcomeEmail;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * Display the payment page.
     */
    public function paypal(): View
    {
        return view('paypal_new');
    }

    public function paypal_mobile(): View
    {
        return view('paypal_mobile');
    }

    public function paypalPost(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'plan' => 'required|string',
            'password' => 'required|string|min:8',
            'coupon_code' => 'nullable|string',
        ]);

        // Check if the user already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->with('paypal_error', 'User with this email already exists.');
        }

        // Validate coupon code if provided (but don't process it yet)
        $couponOwner = null;
        if ($request->filled('coupon_code')) {
            $couponOwner = User::where('coupon_code', $request->input('coupon_code'))->first();
            
            if (!$couponOwner) {
                return back()->with('paypal_error', 'Invalid Coupon.');
            }

            // Check if the coupon has already been used for non-partner users
            if (!$couponOwner->hasRole('partner') && $couponOwner->coupon_used) {
                return back()->with('paypal_error', 'Coupon has already been used.');
            }
        }

        // Store user data in session for PayPal callback
        session([
            'paypal_user_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Hash password before storing
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'plan' => $request->plan,
                'coupon_code' => $request->coupon_code ?? '',
            ]
        ]);

        // Create PayPal subscription
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $planIds = [
                'basic' => $this->createPaypalPlan($provider, 'Basic Plan', 5.99),
                'standard' => $this->createPaypalPlan($provider, 'Standard Plan', 11.99),
                'premium' => $this->createPaypalPlan($provider, 'Premium Plan', 19.99),
            ];

            $selectedPlanId = $planIds[$request->plan];

            $subscription = $provider->createSubscription([
                'plan_id' => $selectedPlanId,
                'subscriber' => [
                    'name' => [
                        'given_name' => $request->name,
                        'surname' => ''
                    ],
                    'email_address' => $request->email,
                ],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    'locale' => 'en-US',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'payment_method' => [
                        'payer_selected' => 'PAYPAL',
                        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                    ],
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                ],
            ]);

            if (isset($subscription['id']) && isset($subscription['links'])) {
                foreach ($subscription['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return back()->with('paypal_error', 'Something went wrong with PayPal.');

        } catch (\Exception $e) {
            return back()->with('paypal_error', 'PayPal Error: ' . $e->getMessage());
        }
    }

    private function createPaypalPlan($provider, $planName, $price)
    {
        // Create product first
        $product = $provider->createProduct([
            'id' => uniqid(),
            'name' => $planName,
            'description' => $planName,
            'type' => 'SERVICE',
            'category' => 'SOFTWARE',
        ]);

        // Create billing plan
        $plan = $provider->createPlan([
            'product_id' => $product['id'],
            'name' => $planName,
            'description' => $planName,
            'status' => 'ACTIVE',
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'MONTH',
                        'interval_count' => 1,
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 0,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => $price,
                            'currency_code' => 'GBP',
                        ],
                    ],
                ],
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'GBP',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 3,
            ],
        ]);

        return $plan['id'];
    }

    public function success(Request $request): RedirectResponse
    {
        $subscriptionId = $request->query('subscription_id');
        $userData = session('paypal_user_data');

        if (!$subscriptionId || !$userData) {
            return redirect()->route('dashboard')->with('error', 'Invalid PayPal session.');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $subscription = $provider->showSubscriptionDetails($subscriptionId);

            if ($subscription && $subscription['status'] == 'ACTIVE') {
                
                // Double-check if user already exists
                $existingUser = User::where('email', $userData['email'])->first();
                if ($existingUser) {
                    session()->forget('paypal_user_data');
                    return redirect()->route('dashboard')->with('error', 'User already exists.');
                }

                // Create the user after successful payment
                $couponCode = $userData['name'] . strtoupper(uniqid());
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'], // Already hashed
                    'user_role' => 'customer',
                    'coupon_code' => $couponCode,
                    'reffered_by' => $userData['reffered_by'],
                ])->assignRole('customer');

                // Process coupon code if provided
                if (!empty($userData['coupon_code'])) {
                    $couponOwner = User::where('coupon_code', $userData['coupon_code'])->first();

                    if ($couponOwner) {
                        $commissionAmount = '';

                        if ($couponOwner->hasRole('partner')) {
                            $couponOwner->increment('affiliate_count');
                            $affiliateCount = $couponOwner->affiliate_count;

                            $plans = [
                                'basic' => 5.99,
                                'standard' => 11.99,
                                'premium' => 19.99,
                            ];

                            $planAmount = $plans[$userData['plan']] ?? 0;

                            if ($affiliateCount <= 50) {
                                $commissionAmount = $planAmount * 0.20;
                            } else {
                                $commissionAmount = $planAmount * 0.30;
                            }

                            CouponUsage::create([
                                'partner_id' => $couponOwner->id,
                                'user_id' => $user->id,
                            ]);
                        } else {
                            $commissionAmount = 5;
                            $couponOwner->update(['coupon_used' => true]);
                        }

                        if ($commissionAmount) {
                            $couponOwner->increment('commission_amount', $commissionAmount);
                        }
                    }
                }

                // Update user subscription details
                $planName = ucfirst($userData['plan']);

                $user->update([
                    'paypal_subscription_id' => $subscriptionId,
                    'subscribed_package' => $planName,
                    'trial_ends_at' => now()->addMonth(),
                ]);

                // Update all users created by this user
                User::where('created_by', $user->id)
                    ->update([
                        'subscribed_package' => $planName,
                        'trial_ends_at' => now()->addMonth(),
                    ]);

                // Send welcome email
                $user->notify(new WelcomeEmail($user));

                // Clear session data
                session()->forget('paypal_user_data');

                return redirect()->route('dashboard')->with('success', 'PayPal subscription created successfully!');
            }

            return redirect()->route('dashboard')->with('error', 'PayPal subscription verification failed.');

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'PayPal Error: ' . $e->getMessage());
        }
    }

    public function cancel(): RedirectResponse
    {
        session()->forget('paypal_user_data');
        return redirect()->route('stripe')->with('error', 'PayPal payment was cancelled.');
    }

    public function cancelSubscription(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->paypal_subscription_id) {
            return back()->with('error', 'No active PayPal subscription found.');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->cancelSubscription($user->paypal_subscription_id, 'User requested cancellation');

            if ($response) {
                $user->update([
                    'paypal_subscription_id' => null,
                ]);

                return back()->with('success', 'Your PayPal subscription has been cancelled.');
            }

            return back()->with('error', 'Failed to cancel PayPal subscription.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error canceling PayPal subscription: ' . $e->getMessage());
        }
    }

    public function resubscribe(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'plan' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Store user data in session for PayPal callback
        session([
            'paypal_resubscribe_data' => [
                'user_id' => $user->id,
                'plan' => $request->plan,
                'email' => $request->email,
            ]
        ]);

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $planIds = [
                'basic' => $this->createPaypalPlan($provider, 'Basic Plan', 5.99),
                'standard' => $this->createPaypalPlan($provider, 'Standard Plan', 11.99),
                'premium' => $this->createPaypalPlan($provider, 'Premium Plan', 19.99),
            ];

            $selectedPlanId = $planIds[$request->plan];

            $subscription = $provider->createSubscription([
                'plan_id' => $selectedPlanId,
                'subscriber' => [
                    'name' => [
                        'given_name' => $user->name,
                        'surname' => ''
                    ],
                    'email_address' => $user->email,
                ],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    'locale' => 'en-US',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'payment_method' => [
                        'payer_selected' => 'PAYPAL',
                        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                    ],
                    'return_url' => route('paypal.resubscribesuccess'),
                    'cancel_url' => route('paypal.cancel'),
                ],
            ]);

            if (isset($subscription['id']) && isset($subscription['links'])) {
                foreach ($subscription['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return back()->with('error', 'Something went wrong with PayPal resubscription.');

        } catch (\Exception $e) {
            return back()->with('error', 'PayPal Error: ' . $e->getMessage());
        }
    }

    public function resubscribesuccess(Request $request): RedirectResponse
    {
        $subscriptionId = $request->query('subscription_id');
        $userData = session('paypal_resubscribe_data');

        if (!$subscriptionId || !$userData) {
            return redirect()->route('customer.dashboard')->with('error', 'Invalid PayPal session.');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $subscription = $provider->showSubscriptionDetails($subscriptionId);

            if ($subscription && $subscription['status'] == 'ACTIVE') {
                $user = User::find($userData['user_id']);
                
                if ($user) {
                    $planName = ucfirst($userData['plan']);

                    $user->update([
                        'paypal_subscription_id' => $subscriptionId,
                        'subscribed_package' => $planName,
                        'trial_ends_at' => now()->addMonth(),
                    ]);

                    // Update all users created by this user
                    User::where('created_by', $user->id)
                        ->update([
                            'subscribed_package' => $planName,
                            'trial_ends_at' => now()->addMonth(),
                        ]);

                    $user->notify(new WelcomeEmail($user));

                    // Clear session data
                    session()->forget('paypal_resubscribe_data');

                    return redirect()->route('customer.dashboard')->with('success', 'PayPal subscription created successfully!');
                }
            }

            return redirect()->route('customer.dashboard')->with('error', 'PayPal subscription verification failed.');

        } catch (\Exception $e) {
            return redirect()->route('customer.dashboard')->with('error', 'PayPal Error: ' . $e->getMessage());
        }
    }
}