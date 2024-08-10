<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Stripe\Exception\CardException;
use App\Models\User;

class StripePaymentController extends Controller
{
    /**
     * Display the payment page.
     */
    public function stripe(): View
    {
        return view('stripe');
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
        ]);

        // Check if the email exists in the database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('stripe_error', 'Email not found in the system.');
        }

        // Map the plan amount to the package name
        $packageNames = [
            '8' => 'Basic',
            '20' => 'Standard',
            '40' => 'Premium'
        ];

        $packageName = $packageNames[$request->plan] ?? 'Unknown Package';

        try {
            // Create the charge with customer details
            Stripe\Charge::create([
                "amount" => $request->plan * 100, // Amount based on selected plan
                "currency" => "gbp", 
                "source" => $request->stripeToken,
                "description" => "Payment for {$packageName} membership plan.",
                "receipt_email" => $request->email, // Send receipt to the provided email
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

            // Update the user record with the subscribed package and trial end date
            $user->update([
                'subscribed_package' => $packageName,
                'trial_ends_at' => now()->addMonth(),
            ]);

            return back()->with('success', 'Payment successful! Your subscription has been updated.');
        } catch (CardException $e) {
            // Handle the error and pass it to the view
            return back()->with('stripe_error', $e->getMessage());
        }
    }
}
