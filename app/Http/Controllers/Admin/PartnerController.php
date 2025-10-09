<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\CouponUsage;
use App\Models\UserBankDetails;
use App\Notifications\WelcomeEmailPartner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\EncryptionHelper;
use Illuminate\Support\Facades\DB;
use Mail;
use Str;

class PartnerController extends Controller
{
    /**
     * Display a listing of the partners.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $partners = User::role('partner')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function view_refferals($id)
    {
        $referredUsers = CouponUsage::with('user')
            ->where('partner_id', $id)
            ->latest()
            ->get();
        return view('admin.partners.view_refferals', compact('referredUsers'));
    }

    public function view_bank_accounts($id)
    {
        $bankAccounts = UserBankDetails::with('user')
            ->where('user_id', $id)
            ->latest()
            ->get();
        return view('admin.partners.view_bank_accounts', compact('bankAccounts'));
    }

    public function send_invite()
    {
        return view('admin.partners.send_invite');
    }

    /**
     * Show the form for creating a new partner.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created partner in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'contact_number' => 'required',
            'access_type' => 'required',
        ]);

        $couponCode = $request->name . strtoupper(uniqid());

        try {
            DB::beginTransaction();

            $partner = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'phone_number' => $request->contact_number,
                'access_type' => $request->access_type,
                'profession' => $request->profession,
                'coupon_code' => $couponCode, // Store the generated coupon code
                'trial_ends_at' => now()->addYears(10),
                'user_role' => 'partner',
                'subscribed_package' => 'Premium',
                'password' => bcrypt('1234'),
            ]);

            // Assign 'partner' role to the newly created user
            $partner->assignRole('partner');


            DB::commit();

            $message = "
            <h2>Hello {$partner->name},</h2>
            <p>You’ve been invited to use <strong>Executor Hub</strong>!</p>
            <p>Your account has been created. Use the following credentials to log in:</p>
            <ul>
                <li>Email: {$partner->email}</li>
                <li>Password: 1234</li>
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

            $partner->notify(new WelcomeEmailPartner($partner));
            return redirect()->route('admin.partners.index')->with('success', 'Partner created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // SEND INVITE TO FREINDS
    public function send_invite_email(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $couponCode = $request->name . strtoupper(uniqid());

        try {
            DB::beginTransaction();
            $tempPassword = Str::random(10);
            $partner = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'coupon_code' => $couponCode, // Store the generated coupon code
                'trial_ends_at' => now()->addYears(10),
                'subscribed_package' => 'Premium',
                'user_role' => 'partner',
                'password' => $tempPassword,
            ]);

            // Assign 'partner' role to the newly created user
            $partner->assignRole('partner');

            DB::commit();

            $message = "
            <h2>Hello {$partner->name},</h2>
            <p>You’ve been invited to use <strong>Executor Hub</strong>!</p>
            <p>Your account has been created. Use the following credentials to log in:</p>
            <ul>
                <li>Email: {$partner->email}</li>
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

            $partner->notify(new WelcomeEmailPartner($partner));
            return redirect()->route('admin.partners.index')->with('success', 'Invitation Sent Successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified partner.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($encryptedId)
    {
        $id = EncryptionHelper::decryptId($encryptedId);
        $partner = User::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified partner in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'contact_number' => 'required',
            'access_type' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $partner = User::findOrFail($id);
            $partner->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'phone_number' => $request->contact_number,
                'access_type' => $request->access_type,
                'profession' => $request->profession,

            ]);

            DB::commit();
            return redirect()->route('admin.partners.index')->with('success', 'Partner profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified partner from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $partner = User::findOrFail($id);
            $partner->delete();

            DB::commit();
            return redirect()->route('admin.partners.index')->with('success', 'Partner profile deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
