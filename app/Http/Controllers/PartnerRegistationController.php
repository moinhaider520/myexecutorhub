<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\WelcomeEmail;
use DB;
use Hash;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerRegistationController extends Controller
{
    public function index()
    {
        return view('auth.register_partner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
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

        $couponCode = $request->name . strtoupper(uniqid());
        $accesstype = 'Collaborator';

        try {
            DB::beginTransaction();

            $partner = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'access_type' => $accesstype,
                'coupon_code' => $couponCode, // Store the generated coupon code
                'trial_ends_at' => now()->addYears(10),
                'subscribed_package' => 'Premium',
                'user_role' => 'partner',
                'password' => Hash::make($request->password),
            ]);

            // Assign 'partner' role to the newly created user
            $partner->assignRole('partner');

            DB::commit();
            $partner->notify(new WelcomeEmail($partner));

            // Authenticate the user
            Auth::login($partner);

            return redirect()->route('partner.dashboard')->with('success', 'Welcome aboard!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
