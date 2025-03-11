<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Stripe\Exception\CardException;
use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\WelcomeEmail;
use Carbon\Carbon;

class StripePaymentController extends Controller
{
    /**
     * Display the payment page.
     */
    public function stripe(): View
    {
        return view('stripe');
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
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Validate the required fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'plan' => 'required|numeric|min:8',
            'password' => 'required_if:user_type,new|nullable|string|min:8',
            'coupon_code' => 'nullable|string', // Optional coupon code
        ]);

        $user = null;

        // Check if the user is an existing user
        if ($request->user_type === 'existing') {
            // Check if the email exists in the database
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->with('stripe_error', 'Email not found in the system.');
            }

            // Check if the coupon code has been used by this user
            if ($request->filled('coupon_code') && $user->coupon_code === $request->input('coupon_code')) {
                return back()->with('stripe_error', 'You cannot use your own coupon code.');
            }
        }

        // Handle new user registration
        if ($request->user_type === 'new') {
            // Generate a unique coupon code
            $couponCode = 'COUPON-' . strtoupper(uniqid());

            // Register the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'trial_ends_at' => now()->addDays(7), // Set trial end date to 7 days from now
                'subscribed_package' => "free_trial",
                'user_role' => 'customer',
                'coupon_code' => $couponCode, // Store the generated coupon code
            ])->assignRole('customer');
        }

        // Check if a valid coupon code is provided
        if ($request->filled('coupon_code')) {
            $couponOwner = User::where('coupon_code', $request->input('coupon_code'))->first();

            if ($couponOwner) {
                // Check if the coupon has already been used
                if ($couponOwner->coupon_used) {
                    return back()->with('stripe_error', 'Coupon has already been used.');
                }

                $commissionAmount = '';
                // Calculate the commission amount based on the coupon owner role
                if ($couponOwner->hasRole('partner')) {
                    // Calculate the commission amount (20% of the plan amount)
                    $planAmount = $request->input('plan');
                    $commissionAmount = ($planAmount * 0.20);

                    // Do not mark the coupon as used if the coupon owner has the 'partner' role
                } else {
                    $commissionAmount = '5'; // Or calculate based on the plan amount

                    // Mark the coupon as used if the coupon owner does not have the 'partner' role
                    $couponOwner->update(['coupon_used' => true]);
                }

                // Update the commission amount for the coupon code owner
                $couponOwner->increment('commission_amount', $commissionAmount);
            } else {
                return back()->with('stripe_error', 'Invalid Coupon.');
            }
        }


        // Check if the user is joining after the free trial
        $joiningAfterFreeTrial = $user->subscribed_package === "free_trial" &&
            Carbon::parse($user->trial_ends_at)->isPast();


        // Map the plan amount to the package name
        $packageNames = [
            '5.99' => 'Basic',
            '11.99' => 'Standard',
            '19.99' => 'Premium'
        ];
        $packageName = $packageNames[$request->plan] ?? 'Unknown Package';

        try {
            // Process the payment
            Stripe\Charge::create([
                "amount" => $request->plan * 100, // Amount in cents
                "currency" => "gbp",
                "source" => $request->stripeToken,
                "description" => "Payment for {$packageName} membership plan.",
                "receipt_email" => $request->email,
                "shipping" => [
                    "name" => $request->name,
                    "address" => [
                        "line1" => $request->address_line1,
                        "city" => $request->city,
                        "postal_code" => $request->postal_code,
                        "country" => $request->country,
                    ],
                ],
            ]);

            // Update the user's subscription details
            $user->update([
                'subscribed_package' => $packageName,
                'trial_ends_at' => now()->addMonth(),
            ]);

            // Update all users created by this user
            User::where('created_by', $user->id)
                ->update([
                    'subscribed_package' => $packageName,
                    'trial_ends_at' => now()->addMonth(),
                ]);

            // If the user is joining after a free trial, send a welcome email
            if ($joiningAfterFreeTrial) {
                $user->notify(new WelcomeEmail($user, true));
            } if ($request->user_type === 'new') {
                $user->notify(new WelcomeEmail($user));
            }

            // Redirect to login page after successful payment
            return redirect()->route('login')->with('success', 'Payment successful! Your subscription has been updated.');
        } catch (CardException $e) {
            // Handle Stripe errors
            return back()->with('stripe_error', $e->getMessage());
        }
    }
}
