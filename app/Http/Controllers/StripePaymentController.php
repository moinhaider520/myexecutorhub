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
    // public function stripePost(Request $request): RedirectResponse
    // {
    //     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     // Validate the required fields
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'address_line1' => 'required|string|max:255',
    //         'city' => 'required|string|max:255',
    //         'postal_code' => 'required|string|max:10',
    //         'country' => 'required|string|max:255',
    //         'plan' => 'required|numeric|min:8',
    //         'password' => 'required_if:user_type,new|nullable|string|min:8',
    //         'coupon_code' => 'nullable|string', // Optional coupon code
    //     ]);

    //     $user = null;

    //     // Check if the user is an existing user
    //     if ($request->user_type === 'existing') {
    //         // Check if the email exists in the database
    //         $user = User::where('email', $request->email)->first();

    //         if (!$user) {
    //             return back()->with('stripe_error', 'Email not found in the system.');
    //         }

    //         // Check if the coupon code has been used by this user
    //         if ($request->filled('coupon_code') && $user->coupon_code === $request->input('coupon_code')) {
    //             return back()->with('stripe_error', 'You cannot use your own coupon code.');
    //         }
    //     }

    //     // Handle new user registration
    //     if ($request->user_type === 'new') {
    //         // Generate a unique coupon code
    //         $couponCode = 'COUPON-' . strtoupper(uniqid());

    //         // Register the user
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => bcrypt($request->password),
    //             'trial_ends_at' => now()->addDays(7), // Set trial end date to 7 days from now
    //             'subscribed_package' => "free_trial",
    //             'user_role' => 'customer',
    //             'coupon_code' => $couponCode, // Store the generated coupon code
    //         ])->assignRole('customer');
    //     }

    //     // Check if a valid coupon code is provided
    //     if ($request->filled('coupon_code')) {
    //         $couponOwner = User::where('coupon_code', $request->input('coupon_code'))->first();

    //         if ($couponOwner) {
    //             // Check if the coupon has already been used
    //             if ($couponOwner->coupon_used) {
    //                 return back()->with('stripe_error', 'Coupon has already been used.');
    //             }

    //             $commissionAmount = '';
    //             // Calculate the commission amount based on the coupon owner role
    //             if ($couponOwner->hasRole('partner')) {
    //                 // Calculate the commission amount (20% of the plan amount)
    //                 $planAmount = $request->input('plan');
    //                 $commissionAmount = ($planAmount * 0.20);

    //                 // Do not mark the coupon as used if the coupon owner has the 'partner' role
    //             } else {
    //                 $commissionAmount = '5'; // Or calculate based on the plan amount

    //                 // Mark the coupon as used if the coupon owner does not have the 'partner' role
    //                 $couponOwner->update(['coupon_used' => true]);
    //             }

    //             // Update the commission amount for the coupon code owner
    //             $couponOwner->increment('commission_amount', $commissionAmount);
    //         } else {
    //             return back()->with('stripe_error', 'Invalid Coupon.');
    //         }
    //     }


    //     // Check if the user is joining after the free trial
    //     $joiningAfterFreeTrial = $user->subscribed_package === "free_trial" &&
    //         Carbon::parse($user->trial_ends_at)->isPast();


    //     // Map the plan amount to the package name
    //     $packageNames = [
    //         '5.99' => 'Basic',
    //         '11.99' => 'Standard',
    //         '19.99' => 'Premium'
    //     ];
    //     $packageName = $packageNames[$request->plan] ?? 'Unknown Package';

    //     try {
    //         // Process the payment
    //         Stripe\Charge::create([
    //             "amount" => $request->plan * 100, // Amount in cents
    //             "currency" => "gbp",
    //             "source" => $request->stripeToken,
    //             "description" => "Payment for {$packageName} membership plan.",
    //             "receipt_email" => $request->email,
    //             "shipping" => [
    //                 "name" => $request->name,
    //                 "address" => [
    //                     "line1" => $request->address_line1,
    //                     "city" => $request->city,
    //                     "postal_code" => $request->postal_code,
    //                     "country" => $request->country,
    //                 ],
    //             ],
    //         ]);

    //         // Update the user's subscription details
    //         $user->update([
    //             'subscribed_package' => $packageName,
    //             'trial_ends_at' => now()->addMonth(),
    //         ]);

    //         // Update all users created by this user
    //         User::where('created_by', $user->id)
    //             ->update([
    //                 'subscribed_package' => $packageName,
    //                 'trial_ends_at' => now()->addMonth(),
    //             ]);

    //         // If the user is joining after a free trial, send a welcome email
    //         if ($joiningAfterFreeTrial) {
    //             $user->notify(new WelcomeEmail($user, true));
    //         } if ($request->user_type === 'new') {
    //             $user->notify(new WelcomeEmail($user));
    //         }

    //         // Redirect to login page after successful payment
    //         return redirect()->route('login')->with('success', 'Payment successful! Your subscription has been updated.');
    //     } catch (CardException $e) {
    //         // Handle Stripe errors
    //         return back()->with('stripe_error', $e->getMessage());
    //     }
    // }
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
            'coupon_code' => 'nullable|string', // Optional coupon code
        ]);

        // Check if the user already exists and create new user
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $couponCode = 'COUPON-' . strtoupper(uniqid());
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_role' => 'customer',
                'coupon_code' => $couponCode,
            ])->assignRole('customer');
        } else {
            return back()->with('stripe_error', 'User with this email already exists.');
        }

        // Check if a valid coupon code is provided
        if ($request->filled('coupon_code')) {
            $couponOwner = User::where('coupon_code', $request->input('coupon_code'))->first();

            if ($couponOwner) {
                $commissionAmount = '';

                // Check if the coupon owner has the 'partner' role
                if ($couponOwner->hasRole('partner')) {
                    // Increment the affiliate_count for the partner
                    $couponOwner->increment('affiliate_count');

                    // Get the affiliate count to determine commission rate
                    $affiliateCount = $couponOwner->affiliate_count;
                    $planAmount = $request->input('plan');

                    // Calculate the commission amount based on affiliate count
                    if ($affiliateCount <= 50) {
                        $commissionAmount = $planAmount * 0.20;  // 20% for affiliate_count <= 50
                    } else {
                        $commissionAmount = $planAmount * 0.30;  // 30% for affiliate_count > 50
                    }

                    // Do not mark the coupon as used for 'partner' role
                } else {
                    // Check if the coupon has already been used for non-partner users
                    if ($couponOwner->coupon_used) {
                        return back()->with('stripe_error', 'Coupon has already been used.');
                    }

                    // Set a fixed commission for non-partner users
                    $commissionAmount = 5;  // Or calculate based on the plan amount

                    // Mark the coupon as used for non-partner users
                    $couponOwner->update(['coupon_used' => true]);
                }

                // Update the commission amount for the coupon code owner
                $couponOwner->increment('commission_amount', $commissionAmount);
            } else {
                return back()->with('stripe_error', 'Invalid Coupon.');
            }
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

        // Find the user by email
        $user = User::where('email', $session->customer_email)->first();
        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'User not found.');
        }

        // Retrieve Subscription ID
        $subscriptions = Subscription::all(['customer' => $session->customer]);
        $subscription = $subscriptions->data[0] ?? null;

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
                'subscribed_package' => $planName, // Store Plan Name Instead of Price ID
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

            // Map Stripe Price ID to plan names
            $plans = [
                'price_1R6CY5A22YOnjf5ZrChFVLg2' => 'Basic',
                'price_1R6CZDA22YOnjf5ZUEFGbQOE' => 'Standard',
                'price_1R6CaeA22YOnjf5Z0sW3CZ9F' => 'Premium',
            ];

            $planName = $plans[$priceId] ?? 'Unknown';

            $user->update([
                'stripe_subscription_id' => $subscription->id,
                'subscribed_package' => $planName, // Store Plan Name Instead of Price ID
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
