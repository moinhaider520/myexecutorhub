<?php

namespace App\Http\Controllers;

use App\Mail\CustomEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
use Illuminate\Support\Facades\Schema;

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
                'other_hear_about_us' => $request->other_hear_about_us ?? '',
            ],
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        // Redirect to Stripe Checkout page
        return redirect()->away($session->url);
    }

    /**
     * Handle lifetime plan checkout (one-time payment).
     */
    public function lifetimeCheckout(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $validated = $request->validateWithBag('lifetime', [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'plan_tier' => 'required|in:basic,standard,premium',
            'date_of_birth' => 'required|date|before:today',
            'coupon_code' => 'nullable|string',
            'hear_about_us' => 'nullable|string|max:255',
            'other_hear_about_us' => 'nullable|string|max:255|required_if:hear_about_us,Other',
        ]);

        $existingUser = User::where('email', $validated['email'])->first();
        if ($existingUser) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'User with this email already exists.'], 'lifetime');
        }

        $couponOwner = null;
        if (!empty($validated['coupon_code'])) {
            $couponOwner = User::where('coupon_code', $validated['coupon_code'])->first();

            if (!$couponOwner) {
                return back()
                    ->withInput()
                    ->withErrors(['coupon_code' => 'Invalid Coupon.'], 'lifetime');
            }

            if (!$couponOwner->hasRole('partner') && $couponOwner->coupon_used) {
                return back()
                    ->withInput()
                    ->withErrors(['coupon_code' => 'Coupon has already been used.'], 'lifetime');
            }
        }

        $age = Carbon::parse($validated['date_of_birth'])->age;
        $ageGroup = match (true) {
            $age < 50 => 'under_50',
            $age <= 65 => '50_65',
            default => '65_plus',
        };

        $priceMap = [
            'basic' => [
                'under_50' => 'price_1SPhDnA22YOnjf5ZpqgtWDzq',
                '50_65' => 'price_1SPhDnA22YOnjf5ZEvkurnSi',
                '65_plus' => 'price_1SPhDnA22YOnjf5ZHoRBUzNS',
            ],
            'standard' => [
                'under_50' => 'price_1SPhIoA22YOnjf5ZGwF2PSHC',
                '50_65' => 'price_1SPhIoA22YOnjf5ZYmoMp7mq',
                '65_plus' => 'price_1SPhIoA22YOnjf5ZzT5DsohH',
            ],
            'premium' => [
                'under_50' => 'price_1SPhMsA22YOnjf5ZPqml85O2',
                '50_65' => 'price_1SPhMsA22YOnjf5ZLWPUYxOH',
                '65_plus' => 'price_1SPhOVA22YOnjf5Zkia12fek',
            ],
        ];

        $priceId = $priceMap[$validated['plan_tier']][$ageGroup] ?? null;

        if (!$priceId) {
            return back()
                ->withInput()
                ->withErrors(['plan_tier' => 'Unable to determine the correct plan for the provided information.'], 'lifetime');
        }

        $planLabel = match ($validated['plan_tier']) {
            'basic' => 'Lifetime Basic',
            'standard' => 'Lifetime Standard',
            'premium' => 'Lifetime Premium',
        };

        $hashedPassword = bcrypt($validated['password']);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'customer_email' => $validated['email'],
            'customer_creation' => 'always',
            'line_items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ],
            ],
            'metadata' => [
                'checkout_type' => 'lifetime',
                'plan_tier' => $validated['plan_tier'],
                'plan_label' => $planLabel,
                'age_group' => $ageGroup,
                'user_name' => $validated['name'],
                'user_email' => $validated['email'],
                'user_password' => $hashedPassword,
                'user_address' => $validated['address'],
                'user_city' => $validated['city'],
                'user_postal_code' => $validated['postal_code'],
                'user_country' => $validated['country'],
                'coupon_code' => $validated['coupon_code'] ?? '',
                'hear_about_us' => $validated['hear_about_us'] ?? '',
                'other_hear_about_us' => $validated['other_hear_about_us'] ?? '',
            ],
            'success_url' => route('stripe.lifetime.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('home') . '#pricing-1',
        ]);

        return redirect()->away($session->url);
    }

    /**
     * Handle successful lifetime checkout.
     */
    public function lifetimeSuccess(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        $session = Session::retrieve($sessionId, ['expand' => ['line_items.data.price']]);

        if (
            !$session ||
            !$session->customer ||
            ($session->metadata->checkout_type ?? null) !== 'lifetime' ||
            $session->payment_status !== 'paid'
        ) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        if (User::where('email', $session->metadata->user_email)->exists()) {
            return redirect()->route('login')->with('error', 'An account with this email already exists.');
        }

        $rawName = $session->metadata->user_name ?? 'USER';
        $baseCoupon = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $rawName), 0, 6));
        if (empty($baseCoupon)) {
            $baseCoupon = 'USER';
        }
        $couponCode = $baseCoupon . Str::upper(Str::random(6));
        $planLabel = $session->metadata->plan_label ?? 'Lifetime Plan';

        $userData = [
            'name' => $session->metadata->user_name,
            'email' => $session->metadata->user_email,
            'password' => $session->metadata->user_password,
            'user_role' => 'customer',
            'coupon_code' => $couponCode,
            'hear_about_us' => $session->metadata->hear_about_us ?: null,
            'other_hear_about_us' => $session->metadata->other_hear_about_us ?: null,
            'address' => $session->metadata->user_address ?: null,
            'city' => $session->metadata->user_city ?: null,
            'postal_code' => $session->metadata->user_postal_code ?: null,
            'subscribed_package' => $planLabel,
            'trial_ends_at' => now()->addYears(10),
            'stripe_customer_id' => $session->customer,
            'stripe_subscription_id' => null,
        ];

        if (!empty($session->metadata->user_country) && Schema::hasColumn('users', 'country')) {
            $userData['country'] = $session->metadata->user_country;
        }

        $user = User::create($userData)->assignRole('customer');

        $planAmount = ($session->amount_total ?? 0) / 100;

        if (!empty($session->metadata->coupon_code)) {
            $couponOwner = User::where('coupon_code', $session->metadata->coupon_code)->first();

            if ($couponOwner) {
                $relationship = PartnerRelationship::where('sub_partner_id', $couponOwner->id)->first();

                if ($relationship) {
                    $ownerCommission = $planAmount * 0.30;
                    $parentCommission = $planAmount * 0.20;
                    $adminCommission = $planAmount * 0.50;

                    $couponOwner->increment('commission_amount', $ownerCommission);
                    $relationship->parent->increment('commission_amount', $parentCommission);
                    User::role('admin')->first()?->increment('commission_amount', $adminCommission);
                } else {
                    $affiliateCount = CouponUsage::where('partner_id', $couponOwner->id)->count();

                    $commissionAmount = $affiliateCount <= 50
                        ? $planAmount * 0.20
                        : $planAmount * 0.30;

                    $couponOwner->increment('commission_amount', $commissionAmount);
                    $adminCommission = $planAmount - $commissionAmount;
                    User::role('admin')->first()?->increment('commission_amount', $adminCommission);
                }

                CouponUsage::create([
                    'partner_id' => $couponOwner->id,
                    'user_id' => $user->id,
                ]);
            }
        } elseif ($planAmount > 0) {
            User::role('admin')->first()?->increment('commission_amount', $planAmount);
        }

        $name = $session->metadata->user_name;
        $email = $session->metadata->user_email;
        $message = "
            <h2>Hello $name,</h2>
            <p>Thank you for joining Executor Hub — we’re thrilled to have you on board!</p>
            <p>Your secure space to organise, protect, and share your important documents begins now.</p>
            <p>👉 Click below to access your personal dashboard and start exploring:</p>
            <p><a href='https://executorhub.co.uk/customer/dashboard'>[Go to My Dashboard]<a></p>
            <p>Need help? Our support team is always here — just reply to this email.</p>
            <br/><br/>
            <p>Regards,<br>The Executor Hub Team</p>
            <p>© Executor Hub Ltd | <a href='https://executorhub.co.uk/privacy_policy'>[Privacy Policy]</a></p>

            <br /><br />
    <p><b>Executor Hub Team</b></p>
    <p><b>Executor Hub Ltd</b></p>
    <p><b>Empowering Executors, Ensuring Legacies</b></p>
    <p><b>Email: hello@executorhub.co.uk</b></p>
    <p><b>Website: https://executorhub.co.uk</b></p>
    <p><b>ICO Registration: ZB932381</b></p>
    <p><b>This email and any attachments are confidential and intended solely for the recipient.</b></p>
    <p><b>If you are not the intended recipient, please delete it and notify the sender.</b></p>
    <p><b>Executor Hub Ltd accepts no liability for any errors or omissions in this message.</b></p>
        ";

        Mail::to($email)->send(new CustomEmail(
            [
                'subject' => 'Welcome to Executor Hub — let’s tick off your first step today',
                'message' => $message,
            ],
            'You Have Been Invited to Executor Hub.'
        ));

        $user->notify(new WelcomeEmail($user));

        return redirect()->route('login')->with('success', 'Subscription created successfully! Please log in to continue.');
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
            'other_hear_about_us' => $session->metadata->other_hear_about_us,            
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

$name = $session->metadata->user_name;
$email = $session->metadata->user_email;
                        $message = "
            <h2>Hello $name,</h2>
            <p>Thank you for joining Executor Hub — we’re thrilled to have you on board!</p>
            <p>Your secure space to organise, protect, and share your important documents begins now.</p>
            <p>👉 Click below to access your personal dashboard and start exploring:</p>
            <p><a href='https://executorhub.co.uk/customer/dashboard'>[Go to My Dashboard]<a></p>
            <p>Need help? Our support team is always here — just reply to this email.</p>
            <br/><br/>
            <p>Regards,<br>The Executor Hub Team</p>
            <p>© Executor Hub Ltd | <a href='https://executorhub.co.uk/privacy_policy'>[Privacy Policy]</a></p>

            <br /><br />
    <p><b>Executor Hub Team</b></p>
    <p><b>Executor Hub Ltd</b></p>
    <p><b>Empowering Executors, Ensuring Legacies</b></p>
    <p><b>Email: hello@executorhub.co.uk</b></p>
    <p><b>Website: https://executorhub.co.uk</b></p>
    <p><b>ICO Registration: ZB932381</b></p>
    <p><b>This email and any attachments are confidential and intended solely for the recipient.</b></p>
    <p><b>If you are not the intended recipient, please delete it and notify the sender.</b></p>
    <p><b>Executor Hub Ltd accepts no liability for any errors or omissions in this message.</b></p>
        ";

        Mail::to(email)->send(new CustomEmail(
            [
                'subject' => 'Welcome to Executor Hub — let’s tick off your first step today',
                'message' => $message,
            ],
            'You Have Been Invited to Executor Hub.'
        ));

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
