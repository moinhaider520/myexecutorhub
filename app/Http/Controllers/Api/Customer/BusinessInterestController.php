<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessInterest;
use App\Models\BusinessTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessInterestController extends Controller
{
    /**
     * Display a list of business interests for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $businessTypes = BusinessTypes::where('created_by', Auth::id())->get();
            $businessInterests = BusinessInterest::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'businessInterests' => $businessInterests,
                'businessTypes' => $businessTypes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created business interest in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

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
            return response()->json(['success' => true, 'message' => 'Business interest added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified business interest in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

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
            return response()->json(['success' => true, 'message' => 'Business interest updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified business interest from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $businessInterest = BusinessInterest::findOrFail($id);
            $businessInterest->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Business interest deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom business type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_business_type' => 'required|string|max:255|unique:business_types,name'
        ]);

        try {
            BusinessTypes::create([
                'name' => $request->custom_business_type,
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom business type added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
