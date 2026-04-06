<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $couponCode = 'COUPON-' . strtoupper(uniqid());
        $existingUser = User::where('email', $request->email)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->when(
                    $existingUser && $existingUser->canUpgradeToCustomer(),
                    fn ($rule) => $rule->ignore($existingUser?->id)
                ),
            ],
            'password' => ['required', 'string', 'min:8'],
        ]);

        try {
            DB::beginTransaction();
            if ($existingUser && $existingUser->canUpgradeToCustomer()) {
                $existingUser->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'trial_ends_at' => now()->addDays(7),
                    'subscribed_package' => 'free_trial',
                    'preferred_role' => 'customer',
                    'user_role' => 'customer',
                ]);

                if (!$existingUser->hasRole('customer')) {
                    $existingUser->assignRole('customer');
                }

                $existingUser->markExecutorActivated();
                $user = $existingUser->fresh();
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'trial_ends_at' => now()->addDays(7), // Set trial end date to 7 days from now
                    'subscribed_package' => "free_trial",
                    'coupon_code' => $couponCode, // Store the generated coupon code
                    'preferred_role' => 'customer',
                ]);

                $user->assignRole('customer');
            }
            DB::commit();
            $token = $user->createToken($request->email)->plainTextToken;
            $role = $user->activeDashboardRole();
            return response()->json([
                'status' => true,
                'User' => $user,
                'role' => $role,
                'available_roles' => $user->availableDashboardRoles(),
                'token' => $token,
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
