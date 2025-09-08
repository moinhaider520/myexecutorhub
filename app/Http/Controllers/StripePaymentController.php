<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\CardException;
use App\Models\User;
use App\Models\PartnerRelationship;
use App\Models\CouponUsage;
use Illuminate\Support\Str;
use App\Notifications\WelcomeEmail;
use Carbon\Carbon;
use Stripe\Subscription;

class StripePaymentController extends Controller
{
    /**
     * Display the payment page.
     */
    public function stripe(): View
    {
        return view('stripe_new');
    }

    public function stripe_mobile(): View
    {
        return view('stripe_mobile');
    }

    /**
     * Handle the Stripe payment.
     */
    public function stripePost(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'plan' => 'required|string', // Stripe Price ID
            'password' => 'required|string|min:8',
            'assigned_to' => 'nullable',
            'coupon_code' => 'nullable|string', // Optional coupon code
        ]);

        // Check if the user already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->with('stripe_error', 'User with this email already exists.');
        }

        // Validate coupon code if provided (but don't process it yet)
        $couponOwner = null;
        if ($request->filled('coupon_code')) {
            $couponOwner = User::where('coupon_code', $request->input('coupon_code'))->first();

            if (!$couponOwner) {
                return back()->with('stripe_error', 'Invalid Coupon.');
            }

            // Check if the coupon has already been used for non-partner users
            if (!$couponOwner->hasRole('partner') && $couponOwner->coupon_used) {
                return back()->with('stripe_error', 'Coupon has already been used.');
            }
        }

        // Create Stripe Checkout Session with metadata containing user data
        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'customer_email' => $request->email,
            'line_items' => [
                [
                    'price' => $request->plan, // Stripe Price ID
                    'quantity' => 1,
                ]
            ],
            'metadata' => [
                'user_name' => $request->name,
                'user_email' => $request->email,
                'user_password' => bcrypt($request->password),
                'user_city' => $request->city,
                'user_postal_code' => $request->postal_code,
                'user_country' => $request->country,
                'coupon_code' => $request->coupon_code ?? '',
                'reffered_by' => $request->assigned_to ?? '',
                'hear_about_us' => $request->hear_about_us ?? '',
            ],
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        // Redirect to Stripe Checkout page
        return redirect()->away($session->url);
    }

    public function success(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session_id = $request->query('session_id'); // Get session ID from URL
        if (!$session_id) {
            return redirect()->route('dashboard')->with('error', 'Invalid session.');
        }

        // Retrieve session details from Stripe
        $session = Session::retrieve($session_id);
        if (!$session || !$session->customer) {
            return redirect()->route('dashboard')->with('error', 'Invalid session.');
        }

        // Check if user already exists (double-check)
        $existingUser = User::where('email', $session->customer_email)->first();
        if ($existingUser) {
            return redirect()->route('dashboard')->with('error', 'User already exists.');
        }

        // Create the user after successful payment
        $couponCode = $session->metadata->user_name . strtoupper(uniqid());
        $user = User::create([
            'name' => $session->metadata->user_name,
            'email' => $session->metadata->user_email,
            'password' => $session->metadata->user_password, // Already hashed
            'user_role' => 'customer',
            'coupon_code' => $couponCode,
            'reffered_by' => $session->metadata->reffered_by,
            'hear_about_us' => $session->metadata->hear_about_us,
        ])->assignRole('customer');

        // Get Stripe subscription to extract plan amount
        $subscriptions = Subscription::all(['customer' => $session->customer]);
        $subscription = $subscriptions->data[0] ?? null;

        $planAmount = 0;
        if ($subscription) {
            $priceId = $subscription->items->data[0]->price->id;
            $plans = [
                'price_1R6CY5A22YOnjf5ZrChFVLg2' => 5.99,
                'price_1R6CZDA22YOnjf5ZUEFGbQOE' => 11.99,
                'price_1R6CaeA22YOnjf5Z0sW3CZ9F' => 19.99,
            ];
            $planAmount = $plans[$priceId] ?? 0;
        }

        // Process coupon code if provided
        if (!empty($session->metadata->coupon_code)) {
            $couponOwner = User::where('coupon_code', $session->metadata->coupon_code)->first();

            if ($couponOwner) {
                // Find parent partner (if exists)
                $relationship = PartnerRelationship::where('sub_partner_id', $couponOwner->id)->first();

                if ($relationship) {
                    // Sub-partner case (partner created by another partner)
                    $ownerCommission = $planAmount * 0.30;   // 30% → coupon owner
                    $parentCommission = $planAmount * 0.20;  // 20% → parent partner
                    $adminCommission  = $planAmount * 0.50;  // 50% → admin

                    // Credit commissions
                    $couponOwner->increment('commission_amount', $ownerCommission);
                    $relationship->parent->increment('commission_amount', $parentCommission);
                    User::role('admin')->first()?->increment('commission_amount', $adminCommission);
                } else {
                    // Original affiliate commission calculation
                    $affiliateCount = CouponUsage::where('partner_id', $couponOwner->id)->count();

                    if ($affiliateCount <= 50) {
                        $commissionAmount = $planAmount * 0.20;  // 20%
                    } else {
                        $commissionAmount = $planAmount * 0.30;  // 30%
                    }

                    $couponOwner->increment('commission_amount', $commissionAmount);

                    // Give rest to admin
                    $adminCommission = $planAmount - $commissionAmount;
                    User::role('admin')->first()?->increment('commission_amount', $adminCommission);
                }

                // Log coupon usage
                CouponUsage::create([
                    'partner_id' => $couponOwner->id,
                    'user_id'    => $user->id,
                ]);
            }
        } else {
            // No coupon → 100% commission goes to admin
            if ($planAmount > 0) {
                User::role('admin')->first()?->increment('commission_amount', $planAmount);
            }
        }

        // Save subscription details in the user record
        if ($subscription) {
            $priceId = $subscription->items->data[0]->price->id;

            // Map Stripe Price ID to plan names
            $plans = [
                'price_1R6CY5A22YOnjf5ZrChFVLg2' => 'Basic',
                'price_1R6CZDA22YOnjf5ZUEFGbQOE' => 'Standard',
                'price_1R6CaeA22YOnjf5Z0sW3CZ9F' => 'Premium',
            ];

            $planName = $plans[$priceId] ?? 'Unknown';

            $user->update([
                'stripe_customer_id' => $session->customer,
                'stripe_subscription_id' => $subscription->id,
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
        }

        return redirect()->route('dashboard')->with('success', 'Subscription created successfully!');
    }

    public function cancelSubscription(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();

        if (!$user->stripe_subscription_id) {
            return back()->with('error', 'No active subscription found.');
        }

        try {
            // Retrieve the Stripe subscription
            $subscription = Subscription::retrieve($user->stripe_subscription_id);

            // Cancel at the end of the billing period
            $subscription->cancel(['invoice_now' => false, 'prorate' => false]);

            // Update user record to reflect canceled subscription
            $user->update([
                'stripe_subscription_id' => null, // Clear the subscription ID
            ]);

            return back()->with('success', 'Your Subscription Has Been canceled.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error canceling subscription: ' . $e->getMessage());
        }
    }

    public function resubscribe(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $request->validate([
            'email' => 'required|email|max:255',
            'plan' => 'required|string', // Stripe Price ID
        ]);

        // Check if the user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Create Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'customer_email' => $user->email,
            'line_items' => [
                [
                    'price' => $request->plan, // Stripe Price ID
                    'quantity' => 1,
                ]
            ],
            'success_url' => route('stripe.resubscribesuccess') . '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        // Redirect to Stripe Checkout page
        return redirect()->away($session->url);
    }

    public function resubscribesuccess(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session_id = $request->query('session_id'); // Get session ID from URL
        if (!$session_id) {
            return redirect()->route('customer.dashboard')->with('error', 'Invalid session.');
        }

        // Retrieve session details from Stripe
        $session = Session::retrieve($session_id);
        if (!$session || !$session->customer) {
            return redirect()->route('customer.dashboard')->with('error', 'Invalid session.');
        }

        // Find the user by email
        $user = User::where('email', $session->customer_email)->first();
        if (!$user) {
            return redirect()->route('customer.dashboard')->with('error', 'User not found.');
        }

        // Retrieve Subscription ID
        $subscriptions = Subscription::all(['customer' => $session->customer]);
        $subscription = $subscriptions->data[0] ?? null;

        if ($subscription) {
            $priceId = $subscription->items->data[0]->price->id;

            // Map Stripe Price ID to plan names + amounts
            $plans = [
                'price_1R6CY5A22YOnjf5ZrChFVLg2' => ['name' => 'Basic', 'amount' => 5.99],
                'price_1R6CZDA22YOnjf5ZUEFGbQOE' => ['name' => 'Standard', 'amount' => 11.99],
                'price_1R6CaeA22YOnjf5Z0sW3CZ9F' => ['name' => 'Premium', 'amount' => 19.99],
            ];

            $planName   = $plans[$priceId]['name']   ?? 'Unknown';
            $planAmount = $plans[$priceId]['amount'] ?? 0;

            // --- Commission Calculation ---
            $couponUsage = CouponUsage::where('user_id', $user->id)->first();

            if ($couponUsage) {
                $couponOwner = User::find($couponUsage->partner_id);

                if ($couponOwner) {
                    // Check if couponOwner is a sub-partner
                    $relationship = PartnerRelationship::where('sub_partner_id', $couponOwner->id)->first();

                    if ($relationship) {
                        // Sub-partner case
                        $ownerCommission  = $planAmount * 0.30;  // 30%
                        $parentCommission = $planAmount * 0.20;  // 20%
                        $adminCommission  = $planAmount * 0.50;  // 50%

                        $couponOwner->increment('commission_amount', $ownerCommission);
                        $relationship->parent->increment('commission_amount', $parentCommission);
                        User::role('admin')->first()?->increment('commission_amount', $adminCommission);
                    } else {
                        // Regular partner affiliate tier
                        $affiliateCount = CouponUsage::where('partner_id', $couponOwner->id)->count();

                        if ($affiliateCount <= 50) {
                            $commissionAmount = $planAmount * 0.20; // 20%
                        } else {
                            $commissionAmount = $planAmount * 0.30; // 30%
                        }

                        $couponOwner->increment('commission_amount', $commissionAmount);

                        // Rest goes to admin
                        $adminCommission = $planAmount - $commissionAmount;
                        User::role('admin')->first()?->increment('commission_amount', $adminCommission);
                    }
                }
            } else {
                // No coupon used → 100% goes to admin
                if ($planAmount > 0) {
                    User::role('admin')->first()?->increment('commission_amount', $planAmount);
                }
            }
            // --- End Commission Calculation ---

            // Update user subscription
            $user->update([
                'stripe_subscription_id' => $subscription->id,
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
        }

        return redirect()->route('customer.dashboard')->with('success', 'Subscription created successfully!');
    }
}
