<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerWallet;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function index()
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

        return view('customer.membership.membership', compact('wallet'));
    }

    public function checkout_page()
    {
        return view('customer.membership.checkout');
    }
}
