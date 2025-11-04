<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponUsage;
use App\Models\PartnerRelationship;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class MovePartnerController extends Controller
{
    public function index()
    {
        // Get all partners with their parent partner relationship
        $partners = User::role('partner')
            ->with(['parentPartnerRelation.parentPartner'])
            ->get();

        // Get all partners for the dropdown (to assign parent partners)
        $allPartners = User::role('partner')->get();

        return view('admin.move_partners.index', compact('partners', 'allPartners'));
    }

    public function assignPartner(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:users,id',
            'parent_partner_id' => 'nullable|exists:users,id',
        ]);

        // Remove existing relationship if any
        PartnerRelationship::where('sub_partner_id', $request->partner_id)->delete();

        // Create new relationship if parent is selected
        if ($request->parent_partner_id) {
            PartnerRelationship::create([
                'parent_partner_id' => $request->parent_partner_id,
                'sub_partner_id' => $request->partner_id,
            ]);
        }

        return redirect()->route('admin.move_partners.index')
            ->with('success', 'Partner relationship updated successfully');
    }
}
