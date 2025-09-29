<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\CouponUsage;
use App\Models\User;
use App\Notifications\WelcomeEmail;
use Http;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $couponOwner = null;

        // Only validate coupon if user entered one
        if (!empty($data['coupon_code'])) {
            $couponOwner = User::where('coupon_code', $data['coupon_code'])
                ->whereHas('roles', fn($q) => $q->where('name', 'partner'))
                ->first();

            if (!$couponOwner) {
                throw ValidationException::withMessages([
                    'coupon_code' => 'Invalid or unauthorized coupon code.',
                ]);
            }
        }

        // Always create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'trial_ends_at' => now()->addDays(14),
            'subscribed_package' => "free_trial",
            'user_role' => 'customer',
            'hear_about_us' => $data['hear_about_us'],
        ]);

        // If valid coupon, log usage
        if ($couponOwner) {
            CouponUsage::create([
                'partner_id' => $couponOwner->id,
                'user_id' => $user->id,
            ]);
        }

        $user->assignRole('customer');

        $name = $data['name'];
        $message = "
            <h2>Hi $name,</h2>
            <p>Welcome 👋 — you’ve just taken the most important step in protecting your family’s future.</p>
            <p>Today, let’s tick off your first onboarding item:</p>
            <p>✅ Upload one document (your will, insurance, or bank statement).</p>
            <p><a href='https://executorhub.co.uk/login'>👉 [Upload your first document now]</a></p>
            <p>🔒 Peace of mind: Everything you add is protected with bank-grade encryption and stored securely, only visible to you (and later, your chosen executors).</p>
            <p>Regards,<br>Executor Hub Team</p>
        ";

        Mail::to($data['email'])->send(new CustomEmail(
            [
                'subject' => 'Welcome to Executor Hub — let’s tick off your first step today',
                'message' => $message,
            ],
            'You Have Been Invited to Executor Hub.'
        ));

        $user->notify(new WelcomeEmail($user));

        return $user; // ✅ always returns a User
    }
}
