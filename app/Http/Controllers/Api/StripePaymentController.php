<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe;
use Stripe\Exception\CardException;
use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\WelcomeEmail;
use Carbon\Carbon;

class StripePaymentController extends Controller
{
    /**
     * Handle the Stripe payment via API.
     */
    public function stripePayment(Request $request)
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
            'stripeToken' => 'required|string',
        ]);

        $user = null;

        // Handle existing user logic
        if ($request->user_type === 'existing') {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'Email not found in the system.'], 404);
            }

            if ($request->filled('coupon_code') && $user->coupon_code === $request->coupon_code) {
                return response()->json(['error' => 'You cannot use your own coupon code.'], 400);
            }
        }

        // Handle new user registration
        if ($request->user_type === 'new') {
            $couponCode = 'COUPON-' . strtoupper(uniqid());

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'trial_ends_at' => now()->addDays(7),
                'subscribed_package' => "free_trial",
                'user_role' => 'customer',
                'coupon_code' => $couponCode,
            ])->assignRole('customer');
        }

        // Validate coupon code if provided
        if ($request->filled('coupon_code')) {
            $couponOwner = User::where('coupon_code', $request->coupon_code)->first();

            if ($couponOwner) {
                if ($couponOwner->coupon_used) {
                    return response()->json(['error' => 'Coupon has already been used.'], 400);
                }

                $commissionAmount = $couponOwner->hasRole('partner')
                    ? ($request->plan * 0.20)
                    : 5;

                if (!$couponOwner->hasRole('partner')) {
                    $couponOwner->update(['coupon_used' => true]);
                }

                $couponOwner->increment('commission_amount', $commissionAmount);
            } else {
                return response()->json(['error' => 'Invalid Coupon.'], 400);
            }
        }

        $joiningAfterFreeTrial = $user->subscribed_package === "free_trial" &&
            Carbon::parse($user->trial_ends_at)->isPast();

        $packageNames = [
            '8' => 'Basic',
            '20' => 'Standard',
            '40' => 'Premium',
        ];
        $packageName = $packageNames[$request->plan] ?? 'Unknown Package';

        try {
            // Process payment with Stripe
            Stripe\Charge::create([
                "amount" => $request->plan * 100,
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

            // Update user's subscription details
            $user->update([
                'subscribed_package' => $packageName,
                'trial_ends_at' => now()->addMonth(),
            ]);

            // Update associated users created by the user
            User::where('created_by', $user->id)->update([
                'subscribed_package' => $packageName,
                'trial_ends_at' => now()->addMonth(),
            ]);

            // Notify user via email
            if ($joiningAfterFreeTrial) {
                $user->notify(new WelcomeEmail($user, true));
            } elseif ($request->user_type === 'new') {
                $user->notify(new WelcomeEmail($user));
            }

            return response()->json([
                'message' => 'Payment successful! Your subscription has been updated.',
                'user' => $user,
            ], 200);
        } catch (CardException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
