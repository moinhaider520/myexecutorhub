<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class AdvisorsController extends Controller
{
    public function view()
    {
        $roles = ['Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'];

        $advisors = User::with('roles')
            ->where('created_by', Auth::id())
            ->whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })
            ->get();

        return view('customer.advisors.advisors', compact('advisors'));
    }

    public function store(Request $request, ActivityLogger $activityLogger)
    {
        $request->validate([
            'adviser_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'practice_name' => 'required|string|max:255',
            'practice_address' => 'required|string|max:255',
            'email_address' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'required|unique:users,contact_number',
        ]);

        $couponCode = 'COUPON-' . strtoupper(uniqid());

        try {
            DB::beginTransaction();

            $advisor = User::create([
                'name' => $request->name,
                'practice_name' => $request->practice_name,
                'practice_address' => $request->practice_address,
                'email' => $request->email_address,
                'contact_number' => $request->phone_number,
                'password' => bcrypt('1234'),
                'created_by' => Auth::id(),
                'coupon_code' => $couponCode,
                'trial_ends_at' => Auth::user()->trial_ends_at,
                'subscribed_package' => Auth::user()->subscribed_package,
            ]);

            if ($advisor) {
                $advisor->assignRole($request->adviser_type);
            }

            $activityLogger->logManualActivity(
                customerId: Auth::id(),
                module: 'Advisors',
                action: 'created',
                subjectType: 'Advisor',
                subjectId: $advisor->id,
                description: 'Advisor added (' . $advisor->name . ')',
                meta: [
                    'role' => $request->adviser_type,
                    'email' => $advisor->email,
                ]
            );

            DB::commit();

            $authname = Auth::user()->name;
            $message = "
            <h2>Hello {$request->name},</h2>
            <p>Youâ€™ve been invited to use <strong>Executor Hub</strong> as an Adviser by {$authname}.</p>
            <p>Please use the following password and your email to login to the portal.</p>
            <p>Password: 1234</p>
            <p><a href='https://executorhub.co.uk/'>Click here to log in</a></p>
            <p>Regards,<br>Executor Hub Team</p>
        ";

            Mail::to($request->email)->send(new CustomEmail(
                [
                    'subject' => 'You Have Been Invited to Executor Hub.',
                    'message' => $message,
                ],
                'You Have Been Invited to Executor Hub.'
            ));

            return response()->json(['success' => true, 'message' => 'Advisor added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id, ActivityLogger $activityLogger)
    {
        $request->validate([
            'adviser_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'practice_name' => 'required|string|max:255',
            'practice_address' => 'required|string|max:255',
            'email_address' => 'required|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'required|unique:users,contact_number,' . $id,
        ]);

        try {
            DB::beginTransaction();

            $advisor = User::findOrFail($id);
            $advisor->update([
                'name' => $request->name,
                'practice_name' => $request->practice_name,
                'practice_address' => $request->practice_address,
                'email' => $request->email_address,
                'contact_number' => $request->phone_number,
                'password' => bcrypt('1234'),
            ]);

            $advisor->syncRoles([$request->adviser_type]);

            $activityLogger->logManualActivity(
                customerId: Auth::id(),
                module: 'Advisors',
                action: 'updated',
                subjectType: 'Advisor',
                subjectId: $advisor->id,
                description: 'Advisor updated (' . $advisor->name . ')',
                meta: [
                    'role' => $request->adviser_type,
                    'email' => $advisor->email,
                ]
            );

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Advisor updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id, ActivityLogger $activityLogger)
    {
        try {
            DB::beginTransaction();

            $advisor = User::findOrFail($id);

            $activityLogger->logManualActivity(
                customerId: Auth::id(),
                module: 'Advisors',
                action: 'deleted',
                subjectType: 'Advisor',
                subjectId: $advisor->id,
                description: 'Advisor deleted (' . $advisor->name . ')',
                meta: [
                    'email' => $advisor->email,
                ]
            );

            $advisor->delete();

            DB::commit();

            return redirect()->route('customer.advisors.view')->with('success', 'Advisor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
