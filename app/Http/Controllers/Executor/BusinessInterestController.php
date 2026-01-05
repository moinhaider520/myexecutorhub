<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessTypes;
use App\Models\BusinessInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessInterestController extends Controller
{
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        $businessTypes = BusinessTypes::whereIn('created_by', $userIds)->get();
        $businessInterests = BusinessInterest::whereIn('created_by', $userIds)->get();

        return view('executor.assets.business_interest', compact('businessInterests', 'businessTypes'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'business_type' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'shares' => 'required|numeric|min:0',
            'business_value' => 'required|numeric|min:0',
            'share_value' => 'required|numeric|min:0',
            'contact' => 'required|string|max:255',
            'plan_for_shares' => 'required|string|max:255',
            'company_number' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            BusinessInterest::create([
                'business_type' => $request->business_type,
                'business_name' => $request->business_name,
                'shares' => $request->shares,
                'business_value' => $request->business_value,
                'share_value' => $request->share_value,
                'contact' => $request->contact,
                'plan_for_shares' => $request->plan_for_shares,
                'company_number' => $request->company_number,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Business interest added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'business_type' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'shares' => 'required|numeric|min:0',
            'business_value' => 'required|numeric|min:0',
            'share_value' => 'required|numeric|min:0',
            'contact' => 'required|string|max:255',
            'plan_for_shares' => 'required|string|max:255',
            'company_number' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $businessInterest = BusinessInterest::findOrFail($id);
            $businessInterest->update([
                'business_type' => $request->business_type,
                'business_name' => $request->business_name,
                'shares' => $request->shares,
                'business_value' => $request->business_value,
                'share_value' => $request->share_value,
                'contact' => $request->contact,
                'plan_for_shares' => $request->plan_for_shares,
                'company_number' => $request->company_number,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Business interest updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $businessInterest = BusinessInterest::findOrFail($id);
            $businessInterest->delete();
            DB::commit();
            return redirect()->route('executor.business_interest.view')->with('success', 'Business interest deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_business_type' => 'required|string|max:255|unique:business_types,name'
        ]);

        BusinessTypes::create([
            'name' => $request->custom_business_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
