<?php

namespace App\Http\Controllers\Admin;
use App\Mail\CustomEmail;
use App\Notifications\WelcomeEmail;
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
