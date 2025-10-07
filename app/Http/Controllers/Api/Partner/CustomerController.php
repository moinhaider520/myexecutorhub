<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\CouponUsage;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function view()
    {
        try {
            $customers = CouponUsage::with('user')
            ->where('partner_id', auth()->id())
            ->latest()
            ->get();
            return response()->json(['success' => true, 'customers' => $customers], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
