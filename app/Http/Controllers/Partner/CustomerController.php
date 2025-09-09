<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\CouponUsage;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = CouponUsage::with('user')
            ->where('partner_id', auth()->id())
            ->latest()
            ->get();

        return view('partner.customers.index', compact('customers'));
    }
}
