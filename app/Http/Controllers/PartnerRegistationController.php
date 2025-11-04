<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PartnerRelationship;
use App\Notifications\WelcomeEmail;
use App\Notifications\WelcomeEmailPartner;
use DB;
use Hash;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerRegistationController extends Controller
{
    /**
     * Show the partner registration form.
     */
    public function index()
    {
        return view('auth.register_partner');
    }

    /**
     * Store a newly created partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'profession' => 'required|string|max:255',
            'hear_about_us' => 'required|string|max:255',
            'g-recaptcha-response' => [
                'required',
                function ($attribute, $value, $fail) {
                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => config('services.recaptcha.secret_key'),
                        'response' => $value,
                    ]);

                    if (!$response->json('success')) {
                        $fail('Captcha validation failed.');
                    }
                }
            ],
        ]);

        if ($request->coupon_code) {
            // Check coupon validity and role in one query
            $couponOwner = User::where('coupon_code', $request->coupon_code)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'partner');
                })
                ->first();

            if (!$couponOwner) {
                return redirect()->back()->withErrors([
                    'coupon_code' => 'Invalid or unauthorized coupon code.',
                ])->withInput();
            }
        }

        // Generate new coupon code for this partner
        $newCouponCode = $request->name . strtoupper(uniqid());
        $accessType = 'Direct Partners';

        try {
            DB::beginTransaction();

            // Create new partner
            $partner = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'access_type' => $accessType,
                'coupon_code' => $newCouponCode,
                'trial_ends_at' => now()->addYears(10),
                'subscribed_package' => 'Premium',
                'user_role' => 'partner',
                'profession' => $request->profession,
                'hear_about_us' => $request->hear_about_us,
                'other_hear_about_us' => $request->other_hear_about_us,
                'email_notifications' => $request->email_notifications  ?? 0,                
                'password' => Hash::make($request->password),
            ]);

            // Assign 'partner' role
            $partner->assignRole('partner');

            if ($request->coupon_code) {
                // Save parent-child relationship
                PartnerRelationship::create([
                    'parent_partner_id' => $couponOwner->id,
                    'sub_partner_id' => $partner->id,
                ]);
            }


            DB::commit();

            // Send welcome email
            $partner->notify(new WelcomeEmailPartner($partner));

            // Authenticate new partner
            Auth::login($partner);

            return redirect()->route('partner.dashboard')->with('success', 'Welcome aboard!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
