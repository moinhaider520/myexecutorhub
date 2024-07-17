<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\OrgansDonation;
class OrgansDonationController extends Controller
{
    public function view()
    {
        $organ_donations = OrgansDonation::where('created_by', Auth::id())->get();
        return view('customer.donations.organs_donation', compact('organ_donations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donation' => 'required',
        ]);

        try {
            DB::beginTransaction();

            OrgansDonation::create([
                'donation' => $request->donation,
                'organs_to_donate' => $request->organs_to_donate,
                'organs_to_not_donate' => $request->organs_to_not_donate,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Organs Donation added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'donation' => 'required'
        ]);
    
        try {
            DB::beginTransaction();
    
            $donation = OrgansDonation::findOrFail($id);
            $donation->update([
                'donation' => $request->donation,
                'organs_to_donate' => $request->organs_to_donate,
                'organs_to_not_donate' => $request->organs_to_not_donate,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'OrgansDonation updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $digitalAsset = OrgansDonation::findOrFail($id);
            $digitalAsset->delete();
            DB::commit();
            return redirect()->route('customer.organ_donations.view')->with('success', 'Organ Donation deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
