<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProvisionPartnerMailbox;
use App\Mail\CustomEmail;
use App\Models\CouponUsage;
use App\Models\CustomerPartnerAccount;
use App\Models\User;
use App\Notifications\WelcomeEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sign_up_as_partner' => ['required', 'in:yes,no'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     */
    protected function create(array $data)
    {
        $partnerProvisioning = null;

        $user = DB::transaction(function () use ($data, &$partnerProvisioning) {
            $couponOwner = null;

            if (!empty($data['coupon_code'])) {
                $couponOwner = User::where('coupon_code', $data['coupon_code'])
                    ->whereHas('roles', fn($query) => $query->where('name', 'partner'))
                    ->first();

                if (!$couponOwner) {
                    throw ValidationException::withMessages([
                        'coupon_code' => 'Invalid or unauthorized coupon code.',
                    ]);
                }
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'trial_ends_at' => now()->addDays(14),
                'subscribed_package' => 'free_trial',
                'user_role' => 'customer',
                'hear_about_us' => $data['hear_about_us'] ?? null,
                'other_hear_about_us' => $data['other_hear_about_us'] ?? null,
                'email_notifications' => $data['email_notifications'] ?? 0,
            ]);

            if ($couponOwner) {
                CouponUsage::create([
                    'partner_id' => $couponOwner->id,
                    'user_id' => $user->id,
                ]);
            }

            $user->assignRole('customer');

            if (($data['sign_up_as_partner'] ?? 'no') === 'yes') {
                $partnerProvisioning = $this->createLinkedPartnerAccount($user);
            }

            return $user;
        });

        $name = $data['name'];
        $message = "
            <h2>Hello $name,</h2>
            <p>Thank you for joining Executor Hub. We are thrilled to have you on board.</p>
            <p>Your secure space to organise, protect, and share your important documents begins now.</p>
            <p>Click below to access your personal dashboard and start exploring:</p>
            <p><a href='https://executorhub.co.uk/customer/dashboard'>[Go to My Dashboard]<a></p>
            <p>Need help? Our support team is always here. Just reply to this email.</p>
            <br/><br/>
            <p>Regards,<br>The Executor Hub Team</p>
            <p>Executor Hub Ltd | <a href='https://executorhub.co.uk/privacy_policy'>[Privacy Policy]</a></p>
        ";

        Mail::to($data['email'])->send(new CustomEmail(
            [
                'subject' => 'Welcome to Executor Hub - let us get your first step done today',
                'message' => $message,
            ],
            'You Have Been Invited to Executor Hub.'
        ));

        $user->notify(new WelcomeEmail($user));

        if ($partnerProvisioning) {
            ProvisionPartnerMailbox::dispatch(
                $partnerProvisioning['link']->id,
                Crypt::encryptString($partnerProvisioning['temporary_password'])
            );
        }

        return $user;
    }

    protected function createLinkedPartnerAccount(User $customer): array
    {
        $mailboxEmail = $this->generateUniquePartnerMailboxEmail($customer->email);
        $temporaryPassword = Str::random(20);
        $couponCode = 'PARTNER-' . strtoupper(Str::random(10));

        $partnerUser = User::create([
            'name' => $customer->name,
            'email' => $mailboxEmail,
            'password' => Hash::make($temporaryPassword),
            'trial_ends_at' => now()->addDays(14),
            'subscribed_package' => 'partner_mailbox_trial',
            'user_role' => 'partner',
            'status' => 'N',
            'access_type' => 'Customer Mailbox Partner',
            'coupon_code' => $couponCode,
            'hear_about_us' => $customer->hear_about_us,
            'other_hear_about_us' => $customer->other_hear_about_us,
            'email_notifications' => $customer->email_notifications,
        ]);

        $partnerUser->assignRole('partner');

        $link = CustomerPartnerAccount::create([
            'customer_user_id' => $customer->id,
            'partner_user_id' => $partnerUser->id,
            'mailbox_email' => $mailboxEmail,
            'requested_local_part' => Str::before($mailboxEmail, '@'),
            'provision_status' => 'pending',
            'provider' => 'cpanel',
        ]);

        return [
            'link' => $link,
            'temporary_password' => $temporaryPassword,
        ];
    }

    protected function generateUniquePartnerMailboxEmail(string $sourceEmail): string
    {
        $domain = (string) config('services.cpanel.domain', 'executorhub.co.uk');
        $base = Str::of(Str::before($sourceEmail, '@'))
            ->lower()
            ->replaceMatches('/[^a-z0-9._-]/', '')
            ->trim('.-_')
            ->value();

        $base = $base !== '' ? $base : 'partner';
        $candidate = "{$base}@{$domain}";
        $counter = 1;

        while (User::where('email', $candidate)->exists()) {
            $candidate = "{$base}.{$counter}@{$domain}";
            $counter++;
        }

        return $candidate;
    }
}
