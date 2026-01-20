<?php

namespace App\Http\Controllers\Admin;
use App\Mail\CustomEmail;
use App\Notifications\WelcomeEmail;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\EncryptionHelper;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Str;

class CustomerController extends Controller
{
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customers = User::role('customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function invite_for_discount()
    {
        $customers = User::role('customer')->get();
        return view('admin.customers.invite_for_discount',compact('customers'));
    }

    public function send_invite()
    {
        return view('admin.customers.send_invite');
    }

    public function send_invite_post(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'price_id' => 'required|string|max:255',
        ]);

        // Generate a secure token for registration
        $inviteToken = Str::random(64);

        // Store invite data in cache (expires in 30 days)
        Cache::put(
            'admin_invite_' . $inviteToken,
            [
                'name' => $request->name,
                'email' => $request->email,
                'price_id' => $request->price_id,
                'invited_by' => Auth::id(),
                'invited_at' => now(),
            ],
            now()->addDays(30)
        );

        // Generate registration URL
        $registrationUrl = route('admin.invite.register', ['token' => $inviteToken]);

        // Send email to invited user
        $userName = $request->name;
        $userEmail = $request->email;

        $inviteMessage = "
        <h2>Hello $userName,</h2>
        <p>You've been invited to join <strong>Executor Hub</strong>!</p>
        <p>Executor Hub is your secure space to organize, protect, and share your important documents and estate planning information.</p>
        <p><strong>What's Next:</strong></p>
        <ul>
            <li>Complete your registration using the link below</li>
            <li>Choose your subscription plan</li>
            <li>Start organizing your estate planning documents</li>
        </ul>
        <p>👉 Click below to complete your registration (this link expires in 30 days):</p>
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
        <p><b>This email and any attachments are confidential and intended solely for the recipient.</b></p>
        <p><b>If you are not the intended recipient, please delete it and notify the sender.</b></p>
        <p><b>Executor Hub Ltd accepts no liability for any errors or omissions in this message.</b></p>
    ";

        Mail::to($userEmail)->send(new CustomEmail(
            [
                'subject' => "You've Been Invited to Join Executor Hub",
                'message' => $inviteMessage,
            ],
            'Invitation to Join Executor Hub'
        ));

        return redirect()->back()->with('success', 'Invitation sent successfully!');
    }

    public function send_discount_invite(Request $request): RedirectResponse
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Generate a secure token for partner registration
        $partnerToken = Str::random(64);

        // Get the discounted price ID based on main user's plan and age
        $mainUserPlanTier = 'standard';

        // Calculate age from main user's data or use partner's if available
        $mainUserAge = 30; // default
        if (!empty($request->date_of_birth)) {
            $mainUserAge = Carbon::parse($request->date_of_birth)->age;
        }

        $mainUser = User::find($request->customer_id);
        
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
                'primary_user_id' => $request->customer_id,
                'partner_name' => $request->name,
                'partner_email' => $request->email,
                'plan_tier' => $mainUserPlanTier,
                'discounted_price_id' => $discountedPriceId,
                'primary_user_name' => $mainUser->name,
                'partner_coupon_code' => null,
            ],
            now()->addDays(7)
        );

        // Generate registration URL
        $registrationUrl = route('couple.partner.register', ['token' => $partnerToken]);

        // Send email to partner
        $partnerName = $request->name;
        $partnerEmail = $request->email;
        $userName = "Executor Hub";

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


        return redirect()->back()->with('success', 'Invite Sent successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        try {
            DB::beginTransaction();
            $tempPassword = Str::random(10);
            $customer = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'contact_number' => $request->contact_number,
                'trial_ends_at' => now()->addYears(10),
                'subscribed_package' => 'Premium',
                'user_role' => 'customer',
                'password' => bcrypt($tempPassword),
            ]);

            $customer->assignRole('customer');

            DB::commit();

            $message = "
            <h2>Hello {$customer->name},</h2>
            <p>You’ve been invited to use <strong>Executor Hub</strong>!</p>
            <p>Your account has been created. Use the following credentials to log in:</p>
            <ul>
                <li>Email: {$customer->email}</li>
                <li>Password: {$tempPassword}</li>
            </ul>
            <p><a href='https://executorhub.co.uk/login'>Click here to log in</a></p>
            <p>Enjoy free access to the Premium plan, courtesy of your invitation!</p>
            <p>Regards,<br>Executor Hub Team</p>
        ";

            Mail::to($request->email)->send(new CustomEmail(
                [
                    'subject' => 'You Have Been Invited to Executor Hub.',
                    'message' => $message,
                ],
                'You Have Been Invited to Executor Hub.'
            ));

            $customer->notify(new WelcomeEmail($customer));
            return redirect()->route('admin.customers.index')->with('success', 'Customer Created.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified customer.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($encryptedId)
    {
        $id = EncryptionHelper::decryptId($encryptedId);
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $encryptedId)
    {
        $id = EncryptionHelper::decryptId($encryptedId);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'contact_number' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $customer = User::findOrFail($id);
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'contact_number' => $request->contact_number,
            ]);

            DB::commit();
            return redirect()->route('admin.customers.index')->with('success', 'Customer profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified customer from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $customer = User::findOrFail($id);
            $customer->delete();

            DB::commit();
            return redirect()->route('admin.customers.index')->with('success', 'Customer profile deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
