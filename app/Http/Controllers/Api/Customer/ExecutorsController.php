<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ExecutorsController extends Controller
{
    /**
     * Display a list of executors for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $executors = User::role('executor')->where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'executors' => $executors], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created executor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'relationship' => 'required|string',
            'how_acting' => 'required|string',
            'status' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        $couponCode = 'COUPON-' . strtoupper(uniqid());

        try {
            DB::beginTransaction();

            $executor = User::create([
                'title' => $request->title,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'how_acting' => $request->how_acting,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'relationship' => $request->relationship,
                'status' => $request->status,
                'password' => Hash::make($request->password),
                'created_by' => Auth::id(),
                'coupon_code' => $couponCode, // Store the generated coupon code
                'trial_ends_at' => Auth::user()->trial_ends_at,
                'subscribed_package' => Auth::user()->subscribed_package,
            ]);

            $executor->assignRole('executor');

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Executor added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified executor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'how_acting' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'relationship' => 'required|string',
            'status' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        try {
            DB::beginTransaction();

            $executor = User::findOrFail($id);
            $executor->update([
                'title' => $request->title,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'how_acting' => $request->how_acting,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'relationship' => $request->relationship,
                'status' => $request->status,
                'password' => $request->filled('password') ? Hash::make($request->password) : $executor->password,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Executor updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified executor from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $executor = User::findOrFail($id);
            $executor->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Executor deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
