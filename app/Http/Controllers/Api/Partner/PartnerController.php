<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerRelationship;
use App\Models\User;
use App\Notifications\WelcomeEmailPartner;
use DB;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function view()
    {
        try {
            $partners = User::whereIn('id', function ($query) {
                $query->select('sub_partner_id')
                    ->from('partner_relationships')
                    ->where('parent_partner_id', auth()->id());
            })->get();
            return response()->json(['success' => true, 'customers' => $partners], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
{
    try {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'contact_number' => 'required',
            'access_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $couponCode = $request->name . strtoupper(uniqid());

        DB::beginTransaction();

        $partner = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->contact_number,
            'access_type' => $request->access_type,
            'profession' => $request->profession,
            'coupon_code' => $couponCode,
            'user_role' => 'partner',
            'trial_ends_at' => now()->addYears(10),
            'subscribed_package' => 'Premium',
            'password' => bcrypt('1234'),
        ]);

        $partner->assignRole('partner');

        PartnerRelationship::create([
            'parent_partner_id' => auth()->id(),
            'sub_partner_id' => $partner->id,
        ]);

        DB::commit();

        $partner->notify(new WelcomeEmailPartner($partner));

        return response()->json([
            'success' => true,
            'message' => 'Partner added successfully.',
            'data' => $partner
        ], 201);

    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}


    public function view_refferals($id)
    {
        $subpartner = User::find($id);
        $referredUsers = PartnerRelationship::with('user')
            ->where('parent_partner_id', $id)
            ->latest()
            ->get();
        return response()->json(['success' => true, 'referredUsers' => $referredUsers], 200);
    }
}