<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoveCustomerController extends Controller
{
    /**
     * Display all customers with their partner associations.
     */
    public function index()
    {
        $customers = User::role('customer')
            ->with(['usedCouponFrom.partner'])
            ->get();

        $partners = User::role('partner')->get();

        return view('admin.move_customers.index', compact('customers', 'partners'));
    }

    /**
     * Assign a partner to a customer.
     */
    public function assignPartner(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'partner_id' => 'required|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            // Check if customer already has an association
            $existing = CouponUsage::where('user_id', $request->customer_id)->first();

            if ($existing) {
                $existing->update(['partner_id' => $request->partner_id]);
            } else {
                CouponUsage::create([
                    'user_id' => $request->customer_id,
                    'partner_id' => $request->partner_id,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.move_customers.index')
                ->with('success', 'Partner successfully assigned to customer.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
