<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;
use Illuminate\Http\JsonResponse;

class WithdrawalController extends Controller
{
    /**
     * Process the withdrawal request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:5', // Minimum amount set to 5
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        // Check if the amount is a whole number
        if (floor($amount) != $amount) {
            return response()->json(['success' => false, 'message' => 'Withdrawal amount must be a whole number.'], 400);
        }

        // Check if the user has enough commission amount
        if ($user->commission_amount < $amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient commission amount for this withdrawal.'], 400);
        }

        // Create a withdrawal record
        Withdrawal::create([
            'user_id' => $user->id,
            'amount_requested' => $amount,
            'status' => 'pending',
        ]);

        // Deduct the requested amount from the user's commission
        $user->decrement('commission_amount', $amount);

        return response()->json(['success' => true, 'message' => 'Withdrawal request submitted successfully.'], 200);
    }

    /**
     * View withdrawal history for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(): JsonResponse
    {
        $user = Auth::user();

        // Fetch all withdrawals for the logged-in user
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $withdrawals], 200);
    }
}