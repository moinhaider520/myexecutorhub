<?php

namespace App\Http\Controllers;

use App\Mail\CustomEmail;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
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
use Illuminate\Support\Facades\Auth;

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
     * Handle step 1 of lifetime subscription - collect DOB and Plan.
     */
    public function lifetimeStep1(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validateWithBag('lifetime', [
                'date_of_birth' => 'required|date|before:today',
            ]);

            // Check if user is authenticated (upgrade scenario)
            $isUpgrade = Auth::check();
            $redirectParams = [
                'date_of_birth' => $validated['date_of_birth'],
            ];

            if ($isUpgrade) {
                $redirectParams['upgrade'] = '1';
            }

            // Always redirect to step 2 (for both new users and upgrades)
            return redirect(route('stripe.lifetime.step2') . '?' . http_build_query($redirectParams));
        } catch (ValidationException $e) {
            // On validation failure, redirect back with errors
            if (Auth::check()) {
                return redirect()->route('membership.view')
                    ->withErrors($e->errors(), 'lifetime')
                    ->withInput($request->all());
            } else {
                return redirect(route('home') . '#pricing-1')
                    ->withErrors($e->errors(), 'lifetime')
                    ->withInput($request->all());
            }
        }
    }

    /**
     * Display step 2 of lifetime subscription with plan selection and calculated rates.
     */
    public function lifetimeStep2(Request $request): View|RedirectResponse
    {
        // Validate URL parameters - only DOB is required
        $dateOfBirth = $request->query('date_of_birth');
        $isUpgrade = $request->query('upgrade') === '1' && Auth::check();

        if (!$dateOfBirth) {
            $redirectRoute = $isUpgrade
                ? route('customer.membership.view')
                : route('home');

            return redirect($redirectRoute)
                ->with('error', 'Please complete step 1 first.')
                ->withInput();
        }

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $age = Carbon::parse($dateOfBirth)->age;
            $ageGroup = match (true) {
                $age < 50 => 'under_50',
                $age <= 65 => '50_65',
                default => '65_plus',
            };

            $priceMap = [
                // LIVE PRICE ID's
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

                // TEST PRICE ID's
                // 'basic' => [
                //     'under_50' => 'price_1ScmWDPEGGZ0nEjmWbaqsjLU',
                //     '50_65' => 'price_1ScmWDPEGGZ0nEjmfxvxzXgR',
                //     '65_plus' => 'price_1ScmWDPEGGZ0nEjmdUGlofPt',
                // ],
                // 'standard' => [
                //     'under_50' => 'price_1Sco5hPEGGZ0nEjmMTAR8pYM',
                //     '50_65' => 'price_1Sco75PEGGZ0nEjmauW8fA45',
                //     '65_plus' => 'price_1Sco75PEGGZ0nEjmDZbhYSmx',
                // ],
                // 'premium' => [
                //     'under_50' => 'price_1ScoARPEGGZ0nEjmygKuf9lR',
                //     '50_65' => 'price_1ScoAgPEGGZ0nEjmVjowzkWD',
                //     '65_plus' => 'price_1ScoAnPEGGZ0nEjmPjkQBHNt',
                // ],
            ];

            // Retrieve prices for all three plans
            $plans = [];
            foreach (['basic', 'standard', 'premium'] as $planTier) {
                $priceId = $priceMap[$planTier][$ageGroup] ?? null;

                if (!$priceId) {
                    \Log::error('Lifetime Step2: Unable to determine price ID', [
                        'plan_tier' => $planTier,
                        'age_group' => $ageGroup,
                        'age' => $age,
                    ]);
                    continue;
                }

                try {
                    $price = \Stripe\Price::retrieve($priceId);
                    $amount = $price->unit_amount / 100; // Convert from cents to currency units
                    $currency = strtoupper($price->currency);

                    $planLabel = match ($planTier) {
                        'basic' => 'Lifetime Basic',
                        'standard' => 'Lifetime Standard',
                        'premium' => 'Lifetime Premium',
                    };

                    $plans[$planTier] = [
                        'label' => $planLabel,
                        'tier' => $planTier,
                        'amount' => $amount,
                        'currency' => $currency,
                        'price_id' => $priceId,
                    ];
                } catch (\Exception $e) {
                    \Log::error('Lifetime Step2: Stripe API error', [
                        'error' => $e->getMessage(),
                        'price_id' => $priceId,
                        'plan_tier' => $planTier,
                    ]);
                }
            }

            if (empty($plans)) {
                return redirect()->route('home')
                    ->with('error', 'Unable to retrieve pricing information. Please try again later.')
                    ->withInput();
            }

            // Get user data if this is an upgrade
            $user = null;
            if ($isUpgrade) {
                $user = Auth::user();
            }

            return view('lifetime.step2', [
                'date_of_birth' => $dateOfBirth,
                'age' => $age,
                'age_group' => $ageGroup,
                'plans' => $plans,
                'is_upgrade' => $isUpgrade,
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Lifetime Step2: Unexpected error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('home')
                ->with('error', 'An error occurred. Please try again.')
                ->withInput();
        }
    }

    /**
     * Handle lifetime plan checkout (one-time payment).
     */
    public function lifetimeCheckout(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Check if this is an upgrade (user is authenticated)
        $isUpgrade = Auth::check();
        $currentUser = $isUpgrade ? Auth::user() : null;

        // Validation rules - password is optional for upgrades
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'plan_tier' => 'required|in:basic,standard,premium',
            'date_of_birth' => 'required|date|before:today',
            'price_id' => 'nullable|string',
            'coupon_code' => 'nullable|string',
            'hear_about_us' => 'nullable|string|max:255',
            'other_hear_about_us' => 'nullable|string|max:255|required_if:hear_about_us,Other',
        ];

        $add_couple_partner = $request->addCouplePartner;
        $couple_partner_name = $request->partner_name;
        $couple_partner_email = $request->partner_email;

        // Password is required for new users, optional for upgrades
        if (!$isUpgrade) {
            $validationRules['password'] = 'required|string|min:8';
        } else {
            $validationRules['password'] = 'nullable|string|min:8';
        }

        $validated = $request->validateWithBag('lifetime', $validationRules);

        // For upgrades, ensure email matches authenticated user
        if ($isUpgrade && $currentUser) {
            if ($validated['email'] !== $currentUser->email) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'Email must match your account email.'], 'lifetime');
            }
        } else {
            // For new users, check if email already exists
            $existingUser = User::where('email', $validated['email'])->first();
            if ($existingUser) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'User with this email already exists.'], 'lifetime');
            }
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

        // Use price_id from form if provided, otherwise calculate it
        $priceId = $validated['price_id'] ?? null;

        if (!$priceId) {
            // Fallback: Calculate price_id based on DOB and plan_tier
            $age = Carbon::parse($validated['date_of_birth'])->age;
            $ageGroup = match (true) {
                $age < 50 => 'under_50',
                $age <= 65 => '50_65',
                default => '65_plus',
            };

            $priceMap = [
                // LIVE PRICE ID's
                'basic' => [
                    'under_50' => 'price_1SPhDnA22YOnjf5ZpqgtWDzq',
                    '50_65' => 'price_1SPhDnA22YOnjf5ZEvkurnSi',
                    '65_plus' => 'price_1SPhDnA22YOnjf5ZHoRBUzNS',
                    'discounted_under_50' => 'price_1Scsk7A22YOnjf5ZI24Oztp7',
                    'discounted_50_65' => 'price_1ScskdA22YOnjf5ZvMHp2ZAu',
                    'discounted_65_plus' => 'price_1ScslFA22YOnjf5ZdnbIJrCY',
                ],
                'standard' => [
                    'under_50' => 'price_1SPhIoA22YOnjf5ZGwF2PSHC',
                    '50_65' => 'price_1SPhIoA22YOnjf5ZYmoMp7mq',
                    '65_plus' => 'price_1SPhIoA22YOnjf5ZzT5DsohH',
                    'discounted_under_50' => 'price_1ScsloA22YOnjf5ZSKQModCL',
                    'discounted_50_65' => 'price_1ScsmGA22YOnjf5ZIhjJCPrD',
                    'discounted_65_plus' => 'price_1ScsmjA22YOnjf5ZX8EIGdQ1',
                ],
                'premium' => [
                    'under_50' => 'price_1SPhMsA22YOnjf5ZPqml85O2',
                    '50_65' => 'price_1SPhMsA22YOnjf5ZLWPUYxOH',
                    '65_plus' => 'price_1SPhOVA22YOnjf5Zkia12fek',
                    'discounted_under_50' => 'price_1ScsnFA22YOnjf5ZuAulfykt',
                    'discounted_50_65' => 'price_1ScsndA22YOnjf5Z54CQ3DF9',
                    'discounted_65_plus' => 'price_1Scso1A22YOnjf5ZNszrbiNK',
                ],

                // TEST PRICE ID's
                // 'basic' => [
                //     'under_50' => 'price_1ScmWDPEGGZ0nEjmWbaqsjLU',
                //     '50_65' => 'price_1ScmWDPEGGZ0nEjmfxvxzXgR',
                //     '65_plus' => 'price_1ScmWDPEGGZ0nEjmdUGlofPt',
                //     'discounted_under_50' => 'price_1ScmWDPEGGZ0nEjmXkfgron4',
                //     'discounted_50_65' => 'price_1ScmWDPEGGZ0nEjm8JKYQsM6',
                //     'discounted_65_plus' => 'price_1ScmWDPEGGZ0nEjmaKJ2Buqb',
                // ],
                // 'standard' => [
                //     'under_50' => 'price_1Sco5hPEGGZ0nEjmMTAR8pYM',
                //     '50_65' => 'price_1Sco75PEGGZ0nEjmauW8fA45',
                //     '65_plus' => 'price_1Sco75PEGGZ0nEjmDZbhYSmx',
                //     'discounted_under_50' => 'price_1Sco75PEGGZ0nEjmDzR8dIxh',
                //     'discounted_50_65' => 'price_1Sco75PEGGZ0nEjm6FTqqLNq',
                //     'discounted_65_plus' => 'price_1Sco75PEGGZ0nEjmrPDcEevc',
                // ],
                // 'premium' => [
                //     'under_50' => 'price_1ScoARPEGGZ0nEjmygKuf9lR',
                //     '50_65' => 'price_1ScoAgPEGGZ0nEjmVjowzkWD',
                //     '65_plus' => 'price_1ScoAnPEGGZ0nEjmPjkQBHNt',
                //     'discounted_under_50' => 'price_1ScoB1PEGGZ0nEjmGIKdEN2Z',
                //     'discounted_50_65' => 'price_1ScoBJPEGGZ0nEjmiCsGtBAN',
                //     'discounted_65_plus' => 'price_1ScoBZPEGGZ0nEjmxPEf9JB7',
                // ],
            ];

            $priceId = $priceMap[$validated['plan_tier']][$ageGroup] ?? null;

            if (!$priceId) {
                return back()
                    ->withInput()
                    ->withErrors(['plan_tier' => 'Unable to determine the correct plan for the provided information.'], 'lifetime');
            }
        }

        $planLabel = match ($validated['plan_tier']) {
            'basic' => 'Lifetime Basic',
            'standard' => 'Lifetime Standard',
            'premium' => 'Lifetime Premium',
        };

        // For upgrades, use existing password if new password not provided
        $hashedPassword = null;
        if ($isUpgrade && $currentUser) {
            $hashedPassword = !empty($validated['password'])
                ? bcrypt($validated['password'])
                : $currentUser->password;
        } else {
            $hashedPassword = bcrypt($validated['password']);
        }

        // Validate partner email is different from user email
        if ($add_couple_partner === 'Yes' && $couple_partner_email === $validated['email']) {
            return back()
                ->withInput()
                ->withErrors(['partner_email' => 'Partner email must be different from your email.'], 'lifetime');
        }

        // Check if partner email already exists
        if ($add_couple_partner === 'Yes') {
            $existingPartner = User::where('email', $couple_partner_email)->first();
            if ($existingPartner) {
                return back()
                    ->withInput()
                    ->withErrors(['partner_email' => 'A user with this email already exists.'], 'lifetime');
            }
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
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
                'is_upgrade' => $isUpgrade ? '1' : '0',
                'user_id' => $isUpgrade && $currentUser ? $currentUser->id : '',
                'plan_tier' => $validated['plan_tier'],
                'plan_label' => $planLabel,
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
                'add_partner' => $add_couple_partner ?? 'No',
                'partner_name' => $couple_partner_name ?? '',
                'partner_email' => $couple_partner_email ?? '',
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

        // Check if this is an upgrade
        $isUpgrade = ($session->metadata->is_upgrade ?? '0') === '1';
        $userId = !empty($session->metadata->user_id) ? $session->metadata->user_id : null;

        if ($isUpgrade && $userId) {
            // Handle upgrade - update existing user
            $user = User::find($userId);
            if (!$user) {
                return redirect()->route('home')->with('error', 'User not found.');
            }

            // Verify email matches
            if ($user->email !== $session->metadata->user_email) {
                return redirect()->route('home')->with('error', 'Email mismatch.');
            }

            // Update user subscription
            $planLabel = $session->metadata->plan_label ?? 'Lifetime Plan';
            $user->update([
                'subscribed_package' => $planLabel,
                'trial_ends_at' => now()->addYears(10),
                'stripe_customer_id' => $session->customer,
                'stripe_subscription_id' => null, // Lifetime has no subscription
            ]);

            // Cancel existing Stripe subscription if any
            if ($user->stripe_subscription_id) {
                try {
                    $subscription = Subscription::retrieve($user->stripe_subscription_id);
                    $subscription->cancel();
                } catch (\Exception $e) {
                    \Log::error('Error canceling subscription during upgrade: ' . $e->getMessage());
                }
            }

            // Update password if provided
            if (!empty($session->metadata->user_password) && $session->metadata->user_password !== $user->password) {
                $user->update(['password' => $session->metadata->user_password]);
            }

            $planAmount = ($session->amount_total ?? 0) / 100;

            // Handle coupon/commission logic for upgrades
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

                    // Create coupon usage record if it doesn't exist
                    if (!CouponUsage::where('partner_id', $couponOwner->id)->where('user_id', $user->id)->exists()) {
                        CouponUsage::create([
                            'partner_id' => $couponOwner->id,
                            'user_id' => $user->id,
                        ]);
                    }
                }
            } elseif ($planAmount > 0) {
                User::role('admin')->first()?->increment('commission_amount', $planAmount);
            }

            // Send upgrade confirmation email
            $name = $user->name;
            $email = $user->email;
            $message = "
                <h2>Hello $name,</h2>
                <p>Thank you for upgrading to a Lifetime Subscription!</p>
                <p>Your account has been successfully upgraded to {$planLabel}.</p>
                <p>You now have lifetime access to all features with no recurring fees.</p>
                <p>👉 <a href='https://executorhub.co.uk/customer/dashboard'>Access Your Dashboard</a></p>
                <p>Need help? Our support team is always here — just reply to this email.</p>
                <br/><br/>
                <p>Regards,<br>The Executor Hub Team</p>
                <p>© Executor Hub Ltd | <a href='https://executorhub.co.uk/privacy_policy'>[Privacy Policy]</a></p>
            ";

            Mail::to($email)->send(new CustomEmail(
                [
                    'subject' => 'Lifetime Subscription Activated - Executor Hub',
                    'message' => $message,
                ],
                'Lifetime Subscription Activated'
            ));



            return redirect()->route('customer.dashboard')->with('success', 'Successfully upgraded to Lifetime Subscription!');
        }

        // Handle new user registration
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

        // Check eligibility for upgrade before mapping to userData
        $upgradeEndDate = \Carbon\Carbon::create(2026, 12, 25, 23, 59, 59);

        // if ($planLabel === 'Lifetime Standard' && now()->lessThanOrEqualTo($upgradeEndDate)) {
        //     $planLabel = 'Lifetime Premium';
        // }

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


        if ($session->metadata->add_partner === 'Yes' && !empty($session->metadata->partner_email)) {
            // Generate a secure token for partner registration
            $partnerToken = Str::random(64);

            // Get the discounted price ID based on main user's plan and age
            $mainUserPlanTier = $session->metadata->plan_tier;

            // Calculate age from main user's data or use partner's if available
            $mainUserAge = 30; // default
            if (!empty($session->metadata->date_of_birth)) {
                $mainUserAge = Carbon::parse($session->metadata->date_of_birth)->age;
            }

            $ageGroup = match (true) {
                $mainUserAge < 50 => 'under_50',
                $mainUserAge <= 65 => '50_65',
                default => '65_plus',
            };

            // Only basic plan has discounted prices
            $discountedPriceId = null;

            $priceMap = [
                // LIVE PRICE ID's
                'basic' => [
                    'under_50' => 'price_1SPhDnA22YOnjf5ZpqgtWDzq',
                    '50_65' => 'price_1SPhDnA22YOnjf5ZEvkurnSi',
                    '65_plus' => 'price_1SPhDnA22YOnjf5ZHoRBUzNS',
                    'discounted_under_50' => 'price_1Scsk7A22YOnjf5ZI24Oztp7',
                    'discounted_50_65' => 'price_1ScskdA22YOnjf5ZvMHp2ZAu',
                    'discounted_65_plus' => 'price_1ScslFA22YOnjf5ZdnbIJrCY',
                ],
                'standard' => [
                    'under_50' => 'price_1SPhIoA22YOnjf5ZGwF2PSHC',
                    '50_65' => 'price_1SPhIoA22YOnjf5ZYmoMp7mq',
                    '65_plus' => 'price_1SPhIoA22YOnjf5ZzT5DsohH',
                    'discounted_under_50' => 'price_1ScsloA22YOnjf5ZSKQModCL',
                    'discounted_50_65' => 'price_1ScsmGA22YOnjf5ZIhjJCPrD',
                    'discounted_65_plus' => 'price_1ScsmjA22YOnjf5ZX8EIGdQ1',
                ],
                'premium' => [
                    'under_50' => 'price_1SPhMsA22YOnjf5ZPqml85O2',
                    '50_65' => 'price_1SPhMsA22YOnjf5ZLWPUYxOH',
                    '65_plus' => 'price_1SPhOVA22YOnjf5Zkia12fek',
                    'discounted_under_50' => 'price_1ScsnFA22YOnjf5ZuAulfykt',
                    'discounted_50_65' => 'price_1ScsndA22YOnjf5Z54CQ3DF9',
                    'discounted_65_plus' => 'price_1Scso1A22YOnjf5ZNszrbiNK',
                ],

                // TEST PRICE ID's
                // 'basic' => [
                //     'under_50' => 'price_1ScmWDPEGGZ0nEjmWbaqsjLU',
                //     '50_65' => 'price_1ScmWDPEGGZ0nEjmfxvxzXgR',
                //     '65_plus' => 'price_1ScmWDPEGGZ0nEjmdUGlofPt',
                //     'discounted_under_50' => 'price_1ScmWDPEGGZ0nEjmXkfgron4',
                //     'discounted_50_65' => 'price_1ScmWDPEGGZ0nEjm8JKYQsM6',
                //     'discounted_65_plus' => 'price_1ScmWDPEGGZ0nEjmaKJ2Buqb',
                // ],
                // 'standard' => [
                //     'under_50' => 'price_1Sco5hPEGGZ0nEjmMTAR8pYM',
                //     '50_65' => 'price_1Sco75PEGGZ0nEjmauW8fA45',
                //     '65_plus' => 'price_1Sco75PEGGZ0nEjmDZbhYSmx',
                //     'discounted_under_50' => 'price_1Sco75PEGGZ0nEjmDzR8dIxh',
                //     'discounted_50_65' => 'price_1Sco75PEGGZ0nEjm6FTqqLNq',
                //     'discounted_65_plus' => 'price_1Sco75PEGGZ0nEjmrPDcEevc',
                // ],
                // 'premium' => [
                //     'under_50' => 'price_1ScoARPEGGZ0nEjmygKuf9lR',
                //     '50_65' => 'price_1ScoAgPEGGZ0nEjmVjowzkWD',
                //     '65_plus' => 'price_1ScoAnPEGGZ0nEjmPjkQBHNt',
                //     'discounted_under_50' => 'price_1ScoB1PEGGZ0nEjmGIKdEN2Z',
                //     'discounted_50_65' => 'price_1ScoBJPEGGZ0nEjmiCsGtBAN',
                //     'discounted_65_plus' => 'price_1ScoBZPEGGZ0nEjmxPEf9JB7',
                // ],
            ];

            if ($mainUserPlanTier === 'basic') {

                // LIVE PRICE ID
                $discountedPriceMap = [
                    'under_50' => 'price_1Scsk7A22YOnjf5ZI24Oztp7',
                    '50_65' => 'price_1ScskdA22YOnjf5ZvMHp2ZAu',
                    '65_plus' => 'price_1ScslFA22YOnjf5ZdnbIJrCY',
                ];

                // TEST PRICE ID
                // $discountedPriceMap = [
                //     'under_50' => 'price_1ScmWDPEGGZ0nEjmXkfgron4',
                //     '50_65' => 'price_1ScmWDPEGGZ0nEjm8JKYQsM6',
                //     '65_plus' => 'price_1ScmWDPEGGZ0nEjmaKJ2Buqb',
                // ];
                $discountedPriceId = $discountedPriceMap[$ageGroup] ?? null;
            } else if ($mainUserPlanTier === 'standard') {
                // LIVE PRICE ID
                $discountedPriceMap = [
                    'under_50' => 'price_1ScsloA22YOnjf5ZSKQModCL',
                    '50_65' => 'price_1ScsmGA22YOnjf5ZIhjJCPrD',
                    '65_plus' => 'price_1ScsmjA22YOnjf5ZX8EIGdQ1',
                ];

                // TEST PRICE ID
                // $discountedPriceMap = [
                //     'under_50' => 'price_1Sco75PEGGZ0nEjmDzR8dIxh',
                //     '50_65' => 'price_1Sco75PEGGZ0nEjm6FTqqLNq',
                //     '65_plus' => 'price_1Sco75PEGGZ0nEjmrPDcEevc',
                // ];
                $discountedPriceId = $discountedPriceMap[$ageGroup] ?? null;
            } else {
                // LIVE PRICE ID
                $discountedPriceMap = [
                    'under_50' => 'price_1ScsnFA22YOnjf5ZuAulfykt',
                    '50_65' => 'price_1ScsndA22YOnjf5Z54CQ3DF9',
                    '65_plus' => 'price_1Scso1A22YOnjf5ZNszrbiNK',
                ];

                // TEST PRICE ID
                // $discountedPriceMap = [
                //     'under_50' => 'price_1ScoB1PEGGZ0nEjmGIKdEN2Z',
                //     '50_65' => 'price_1ScoBJPEGGZ0nEjmiCsGtBAN',
                //     '65_plus' => 'price_1ScoBZPEGGZ0nEjmxPEf9JB7',
                // ];
                $discountedPriceId = $discountedPriceMap[$ageGroup] ?? null;
            }

            // Store partner registration data in cache (expires in 7 days)
            Cache::put(
                'couple_partner_' . $partnerToken,
                [
                    'primary_user_id' => $user->id,
                    'partner_name' => $session->metadata->partner_name,
                    'partner_email' => $session->metadata->partner_email,
                    'plan_tier' => $mainUserPlanTier,
                    'discounted_price_id' => $discountedPriceId,
                    'primary_user_name' => $user->name,
                    'partner_coupon_code' => $session->metadata->coupon_code,
                ],
                now()->addDays(7)
            );

            // Generate registration URL
            $registrationUrl = route('couple.partner.register', ['token' => $partnerToken]);

            // Send email to partner
            $partnerName = $session->metadata->partner_name;
            $partnerEmail = $session->metadata->partner_email;
            $userName = $session->metadata->user_name;

            $partnerMessage = "
        <h2>Hello $partnerName,</h2>
        <p><strong>$userName</strong> has invited you to join Executor Hub as their couple partner!</p>
        <p>As a couple partner, you'll get access to Executor Hub at a special discounted rate.</p>
        <p><strong>Your Benefits:</strong></p>
        <ul>
            <li>Discounted lifetime access to Executor Hub</li>
            <li>All premium features included</li>
            <li>Secure document management and planning tools</li>
        </ul>
        <p>👉 Click below to complete your registration (this link expires in 7 days):</p>
        <p><a href='$registrationUrl' style='background-color: #4CAF50; color: white; padding: 14px 20px; text-decoration: none; display: inline-block; border-radius: 4px;'>Complete Your Registration</a></p>
        <p>Or copy this link: $registrationUrl</p>
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
    ";

            Mail::to($partnerEmail)->send(new CustomEmail(
                [
                    'subject' => "You've Been Invited to Join Executor Hub as a Couple Partner",
                    'message' => $partnerMessage,
                ],
                'Couple Partner Invitation - Executor Hub'
            ));
        }

        $user->notify(new WelcomeEmail($user));

        return redirect()->route('login')->with('success', 'Subscription created successfully! Please log in to continue.');
    }


    public function showCouplePartnerRegistration(Request $request, string $token)
    {
        // Get registration data from cache
        $registration = Cache::get('couple_partner_' . $token);

        if (!$registration) {
            return redirect()->route('home')->with('error', 'Invalid or expired registration link.');
        }

        // Check if partner email already exists
        if (User::where('email', $registration['partner_email'])->exists()) {
            return redirect()->route('login')->with('error', 'An account with this email already exists.');
        }

        // Get primary user details
        $primaryUser = User::find($registration['primary_user_id']);

        if (!$primaryUser) {
            return redirect()->route('home')->with('error', 'Primary user not found.');
        }

        return view('lifetime.couple-partner-register', [
            'token' => $token,
            'registration' => $registration,
            'primaryUser' => $primaryUser,
        ]);
    }

    public function couplePartnerCheckout(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));


        $validated = $request->validate([
            'token' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'hear_about_us' => 'nullable|string|max:255',
        ]);


        // Get registration data from cache
        $registration = Cache::get('couple_partner_' . $validated['token']);

        if (!$registration) {
            return back()->withErrors(['error' => 'Invalid or expired registration link.']);
        }

        // Check if partner email already exists
        if (User::where('email', $registration['partner_email'])->exists()) {
            return redirect()->route('login')->with('error', 'An account with this email already exists.');
        }

        $dob = $request->date_of_birth;

        // LIVE
        $discountedPriceMap = [
                    'under_50' => 'price_1ScsloA22YOnjf5ZSKQModCL',
                    '50_65' => 'price_1ScsmGA22YOnjf5ZIhjJCPrD',
                    '65_plus' => 'price_1ScsmjA22YOnjf5ZX8EIGdQ1',
                ];
        // TEST
        // $discountedPriceMap = [
        //     'under_50' => 'price_1Sco75PEGGZ0nEjmDzR8dIxh',
        //     '50_65' => 'price_1Sco75PEGGZ0nEjm6FTqqLNq',
        //     '65_plus' => 'price_1Sco75PEGGZ0nEjmrPDcEevc',
        // ];

        // Calculate age
        $age = Carbon::parse($dob)->age;

        // Assign price ID based on age
        if ($age < 50) {
            $priceId = $discountedPriceMap['under_50'];
        } elseif ($age >= 50 && $age <= 65) {
            $priceId = $discountedPriceMap['50_65'];
        } else {
            $priceId = $discountedPriceMap['65_plus'];
        }
        // $priceId = $registration['discounted_price_id'];

        if (!$priceId) {
            return back()->withErrors(['error' => 'Discounted pricing not available for this plan tier.']);
        }

        $planLabel = match ($registration['plan_tier']) {
            'basic' => 'Lifetime Basic',
            'standard' => 'Lifetime Standard',
            'premium' => 'Lifetime Premium',
        };

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'allow_promotion_codes' => true, // No additional coupons for couple partners
            'customer_email' => $registration['partner_email'],
            'customer_creation' => 'always',
            'line_items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ],
            ],
            'metadata' => [
                'checkout_type' => 'couple_partner',
                'registration_token' => $validated['token'],
                'primary_user_id' => $registration['primary_user_id'],
                'plan_tier' => $registration['plan_tier'],
                'partner_coupon_code' => $registration['partner_coupon_code'],
                'plan_label' => $planLabel,
                'user_name' => $registration['partner_name'],
                'user_email' => $registration['partner_email'],
                'user_password' => bcrypt($validated['password']),
                'user_address' => $validated['address'],
                'user_city' => $validated['city'],
                'user_postal_code' => $validated['postal_code'],
                'user_country' => $validated['country'],
                'date_of_birth' => $validated['date_of_birth'],
                'hear_about_us' => $validated['hear_about_us'] ?? '',
                'other_hear_about_us' => $validated['other_hear_about_us'] ?? '',
            ],
            'success_url' => route('couple.partner.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('couple.partner.register', ['token' => $validated['token']]),
        ]);

        return redirect()->away($session->url);
    }

    public function couplePartnerSuccess(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        $session = Session::retrieve($sessionId);

        if (
            !$session ||
            !$session->customer ||
            ($session->metadata->checkout_type ?? null) !== 'couple_partner' ||
            $session->payment_status !== 'paid'
        ) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        // Check if user already exists
        if (User::where('email', $session->metadata->user_email)->exists()) {
            return redirect()->route('login')->with('error', 'An account with this email already exists.');
        }

        // Remove registration data from cache (mark as used)
        Cache::forget('couple_partner_' . $session->metadata->registration_token);

        // Generate coupon code
        $rawName = $session->metadata->user_name ?? 'USER';
        $baseCoupon = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $rawName), 0, 6));
        if (empty($baseCoupon)) {
            $baseCoupon = 'USER';
        }
        $couponCode = $baseCoupon . Str::upper(Str::random(6));

        $planLabel = $session->metadata->plan_label ?? 'Lifetime Plan';

        // Upgrade rule: Until 25 Dec 2026, rename Lifetime Standard → Lifetime Premium
        $upgradeEndDate = \Carbon\Carbon::create(2026, 12, 25, 23, 59, 59);

        // if ($planLabel === 'Lifetime Standard' && now()->lessThanOrEqualTo($upgradeEndDate)) {
        //     $planLabel = 'Lifetime Premium';
        // }

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

        if (!empty($session->metadata->date_of_birth) && Schema::hasColumn('users', 'date_of_birth')) {
            $userData['date_of_birth'] = $session->metadata->date_of_birth;
        }

        $partnerUser = User::create($userData)->assignRole('customer');

        // Handle commissions (goes to admin since it's a discounted couple partner)
        $planAmount = ($session->amount_total ?? 0) / 100;

        if (!empty($session->metadata->partner_coupon_code)) {
            $couponOwner = User::where('coupon_code', $session->metadata->partner_coupon_code)->first();

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
                    'user_id' => $partnerUser->id,
                ]);
            }
        } elseif ($planAmount > 0) {
            User::role('admin')->first()?->increment('commission_amount', $planAmount);
        }

        // Send welcome email to partner
        $name = $session->metadata->user_name;
        $email = $session->metadata->user_email;
        $primaryUser = User::find($session->metadata->primary_user_id);

        $message = "
        <h2>Hello $name,</h2>
        <p>Welcome to Executor Hub! Your account has been successfully created.</p>
        <p>You're now registered as a couple partner with <strong>{$primaryUser->name}</strong> and have lifetime access to all features.</p>
        <p>Your secure space to organise, protect, and share your important documents begins now.</p>
        <p>👉 Click below to access your personal dashboard and start exploring:</p>
        <p><a href='https://executorhub.co.uk/customer/dashboard'>[Go to My Dashboard]</a></p>
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
                'subject' => 'Welcome to Executor Hub — lets tick off your first step today',
                'message' => $message,
            ],
            "Welcome to Executor Hub"
        ));

        $partnerUser->notify(new WelcomeEmail($partnerUser));

        // Notify primary user that their partner has registered
        $primaryUserMessage = "
        <h2>Hello {$primaryUser->name},</h2>
        <p>Great news! Your couple partner <strong>$name</strong> has successfully completed their registration.</p>
        <p>They now have their own Executor Hub account with lifetime access.</p>
        <p>👉 <a href='https://executorhub.co.uk/customer/dashboard'>Access Your Dashboard</a></p>
        <br/><br/>
        <p>Regards,<br>The Executor Hub Team</p>
        <p>© Executor Hub Ltd | <a href='https://executorhub.co.uk/privacy_policy'>[Privacy Policy]</a></p>
    ";

        Mail::to($primaryUser->email)->send(new CustomEmail(
            [
                'subject' => 'Your Couple Partner Has Joined Executor Hub',
                'message' => $primaryUserMessage,
            ],
            'Couple Partner Registration Complete'
        ));

        return redirect()->route('login')->with('success', 'Your account has been created successfully! Please log in to continue.');
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
                'price_1SbHDHPEGGZ0nEjmonVkxxQL' => 5.99,
                'price_1SbHWsPEGGZ0nEjmTAg6neQY' => 11.99,
                'price_1SbHY6PEGGZ0nEjmJOsA4h41' => 19.99,
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
                    $adminCommission = $planAmount * 0.50;  // 50% → admin

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
                    'user_id' => $user->id,
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
                'price_1SbHDHPEGGZ0nEjmonVkxxQL' => 'Basic',
                'price_1SbHWsPEGGZ0nEjmTAg6neQY' => 'Standard',
                'price_1SbHY6PEGGZ0nEjmJOsA4h41' => 'Premium',
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

            Mail::to($email)->send(new CustomEmail(
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
                'price_1SbHDHPEGGZ0nEjmonVkxxQL' => ['name' => 'Basic', 'amount' => 5.99],
                'price_1SbHWsPEGGZ0nEjmTAg6neQY' => ['name' => 'Standard', 'amount' => 11.99],
                'price_1SbHY6PEGGZ0nEjmJOsA4h41' => ['name' => 'Premium', 'amount' => 19.99],
            ];

            $planName = $plans[$priceId]['name'] ?? 'Unknown';
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
                        $ownerCommission = $planAmount * 0.30;  // 30%
                        $parentCommission = $planAmount * 0.20;  // 20%
                        $adminCommission = $planAmount * 0.50;  // 50%

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
