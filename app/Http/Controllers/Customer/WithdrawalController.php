<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerWallet;
use App\Models\CustomerWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    /**
     * Display the withdraw page.
     */
    public function view()
    {
        $wallet = CustomerWallet::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'available_balance' => 0,
                'pending_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]
        );

        return view('customer.withdraw.withdraw', compact('wallet'));
    }

    /**
     * Process the withdrawal request.
     */
    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');
        $wallet = CustomerWallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'available_balance' => 0,
                'pending_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]
        );

        if ($wallet->available_balance < 100) {
            return back()->with('error', 'You need at least £100 available in your wallet before withdrawing.');
        }

        if ($wallet->available_balance < $amount) {
            return back()->with('error', 'Insufficient available wallet balance to make this withdrawal.');
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'amount_requested' => $amount,
            'status' => 'approved',
        ]);

        $wallet->decrement('available_balance', $amount);
        $wallet->increment('total_withdrawn', $amount);

        CustomerWalletTransaction::create([
            'wallet_id' => $wallet->id,
            'user_id' => $user->id,
            'type' => 'debit',
            'category' => 'withdrawal',
            'amount' => $amount,
            'status' => 'completed',
            'meta' => [
                'processed_at' => now()->toDateTimeString(),
            ],
        ]);

        return back()->with('success', 'Your wallet withdrawal was processed successfully.');
    }

    public function history()
    {
        $user = Auth::user();

        // Fetch all withdrawals for the logged-in user
        $withdrawals = Withdrawal::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('customer.withdraw.history', compact('withdrawals'));
    }
}
