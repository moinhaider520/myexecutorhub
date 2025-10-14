<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OnboardingProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

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
        try {
            // ✅ Step 1: Validate request input
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'relationship' => 'required|string|max:255',
                'how_acting' => 'required|string|max:255',
                'status' => 'required|string|max:50',
                'password' => 'required|confirmed|min:6',
            ]);

            $couponCode = 'COUPON-' . strtoupper(uniqid());

            DB::beginTransaction();

            $executor = User::create([
                'title' => $request->title,
                'name' => $validated['name'],
                'lastname' => $validated['lastname'],
                'how_acting' => $validated['how_acting'],
                'phone_number' => $request->phone_number,
                'email' => $validated['email'],
                'relationship' => $validated['relationship'],
                'status' => $validated['status'],
                'password' => Hash::make($validated['password']),
                'created_by' => Auth::id(),
                'coupon_code' => $couponCode,
                'trial_ends_at' => Auth::user()->trial_ends_at ?? null,
                'subscribed_package' => Auth::user()->subscribed_package ?? null,
            ]);

            $executor->assignRole('executor');

            // Onboarding progress
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['executor_added' => true]
            );

            if (!$progress->executor_added) {
                $progress->executor_added = true;
                $progress->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Executor added successfully.',
            ], 200);

        } catch (ValidationException $e) {
            // ✅ Return validation errors in JSON
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
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
