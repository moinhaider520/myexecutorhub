<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\BusinessTypes;
use App\Models\BusinessInterest;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class BusinessInterestController extends Controller
{
    /**
     * Display the business interests and business types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve business types and business interests created by the authenticated user's creator
            $businessTypes = BusinessTypes::where('created_by', $id)->get();
            $businessInterests = BusinessInterest::where('created_by', $id)->get();

            // Return the business interests and business types as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'business_interests' => $businessInterests,
                    'business_types' => $businessTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve business interests and types',
                'error' => $e->getMessage(),
            ], 500);
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
                'created_by' => $request->created_by,
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
                'created_by' => $request->created_by,
            ]);

            return response()->json(['success' => true, 'message' => 'Custom business type added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
