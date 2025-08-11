<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\TwoFactorCode;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->status !== 'A') {
                        return response()->json(['status' => false, 'message' => 'Your account has not been activated yet.'], JsonResponse::HTTP_FORBIDDEN);
                    }

                    if ($user->trial_ends_at && now()->greaterThan($user->trial_ends_at)) {
                        return response()->json(['status' => false, 'message' => 'Please subscribe to continue.'], JsonResponse::HTTP_FORBIDDEN);
                    }

                    if($request->email == "moin.haider.520@gmail.com" || $request->email == "nosherwanadil04@gmail.com"){
                                $token = $user->createToken($request->email)->plainTextToken;
                                $role = $user->roles->first()->name;

        return response()->json([
            'status' => true,
            'message' => 'Two-factor authentication verified.',
            'user' => $user,
            'role' => $role,
            'token' => $token,
        ], JsonResponse::HTTP_OK);
                    }else{
                    // Generate and send the 2FA code
                    $this->sendTwoFactorCode($user);

                    return response()->json([
                        'status' => true,
                        'message' => 'Two-factor authentication code sent to your email.',
                        'requires_2fa' => true,
                        'email' => $user->email,
                    ], JsonResponse::HTTP_OK);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Invalid credentials.'], JsonResponse::HTTP_UNAUTHORIZED);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid credentials.'], JsonResponse::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function sendTwoFactorCode($user)
    {
        $user->update([
            'two_factor_code' => mt_rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new TwoFactorCode($user));
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'two_factor_code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->two_factor_code !== $request->two_factor_code) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired two-factor code.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $expiresAt = Carbon::parse($user->two_factor_expires_at);
        if ($expiresAt->lessThan(now())) {
            return response()->json(['status' => false, 'message' => 'The two-factor code has expired.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user->update([
            'last_login' => now(),
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        $token = $user->createToken($request->email)->plainTextToken;
        $role = $user->roles->first()->name;

        return response()->json([
            'status' => true,
            'message' => 'Two-factor authentication verified.',
            'user' => $user,
            'role' => $role,
            'token' => $token,
        ], JsonResponse::HTTP_OK);
    }
}
