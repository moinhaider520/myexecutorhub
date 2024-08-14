<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

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
        return view('partner.advisors.advisors', compact('advisors'));
    }

    public function store(Request $request)
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
                'coupon_code' => $couponCode, // Store the generated coupon code
                'trial_ends_at' => Auth::user()->trial_ends_at,
                'subscribed_package' => Auth::user()->subscribed_package,
            ]);

            if ($advisor) {
                $advisor->assignRole($request->adviser_type);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Advisor added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
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

            // Reassign role
            $advisor->syncRoles([$request->adviser_type]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Advisor updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $advisor = User::findOrFail($id);
            $advisor->delete();

            DB::commit();
            return redirect()->route('partner.advisors.view')->with('success', 'Advisor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
