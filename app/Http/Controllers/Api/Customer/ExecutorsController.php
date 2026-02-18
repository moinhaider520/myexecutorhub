<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;
use App\Models\User;
use App\Models\OnboardingProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mail;
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
            $executors = Auth::user()->executors;
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
                'email' => 'required|email|unique:users,email',
                'status' => 'required|string|max:50',
            ]);

            $couponCode = 'COUPON-' . strtoupper(uniqid());

            DB::beginTransaction();

            // 1️⃣ Find executor by email
            $executor = User::where('email', $request->email)->first();
            $password = str()->random(10);
            if (!$executor) {

                $executor = User::create([
                    'title' => $request->title,
                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'how_acting' => $request->how_acting,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'relationship' => $request->relationship,
                    'status' => $request->status,
                    'password' => Hash::make($password),
                ]);

                $executor->assignRole('executor');

                $authname = Auth::user()->name;
                $message = "
            <h2>Hello {$request->name},</h2>
            <p>You’ve been invited to use <strong>Executor Hub</strong> as an Executor by {$authname}.</p>
            <p>Please use the following password and your email to login to the portal.</p>
            <p>Password:{$password}</p>
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
            }

            // 3️⃣ Link executor to customer (pivot)
            Auth::user()->executors()->syncWithoutDetaching([$executor->id]);

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

        try {
            DB::beginTransaction();

            $executor = User::findOrFail($id);
            $executor->update([
                'title' => $request->title,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'how_acting' => $request->how_acting,
                'phone_number' => $request->phone_number,
                'relationship' => $request->relationship,
                'status' => $request->status,
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
