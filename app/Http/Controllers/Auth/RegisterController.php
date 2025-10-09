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
            'other_hear_about_us' => $data['other_hear_about_us'],
            'email_notifications' => $data['email_notifications'] ?? 0,
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
