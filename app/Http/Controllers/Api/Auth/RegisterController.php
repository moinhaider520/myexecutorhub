<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $couponCode = 'COUPON-' . strtoupper(uniqid());

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'trial_ends_at' => now()->addDays(7), // Set trial end date to 7 days from now
                'subscribed_package' => "free_trial",
                'coupon_code' => $couponCode, // Store the generated coupon code
            ])->assignRole('customer');
            DB::commit();
            $token = $user->createToken($request->email)->plainTextToken;
            $role = $user->roles->first()->name;
            return response()->json(['status' => true, 'User' => $user, 'role' => $role, 'token' => $token], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
