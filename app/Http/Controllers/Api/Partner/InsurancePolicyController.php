<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\InsuranceTypes;

class InsurancePolicyController extends Controller
{
    /**
     * Display a list of insurance policies for the authenticated Partner.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $insuranceTypes = InsuranceTypes::where('created_by', Auth::id())->get();
            $insurancePolicies = InsurancePolicy::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'insurancePolicies' => $insurancePolicies, 'insuranceTypes' => $insuranceTypes], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created insurance policy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'insurance_type' => 'required|string|max:255',
            'provider_name' => 'required|string|max:255',
            'policy_number' => 'required|string|max:255',
            'sum_insured' => 'required|numeric|min:0',
            'contact_details' => 'required|string|max:255',
            'beneficiaries' => 'required|string|max:255',
            'policy_end_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            InsurancePolicy::create([
                'insurance_type' => $request->insurance_type,
                'provider_name' => $request->provider_name,
                'policy_number' => $request->policy_number,
                'sum_insured' => $request->sum_insured,
                'contact_details' => $request->contact_details,
                'beneficiaries' => $request->beneficiaries,
                'policy_end_date' => $request->policy_end_date,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Insurance policy added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified insurance policy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'insurance_type' => 'required|string|max:255',
            'provider_name' => 'required|string|max:255',
            'policy_number' => 'required|string|max:255',
            'sum_insured' => 'required|numeric|min:0',
            'contact_details' => 'required|string|max:255',
            'beneficiaries' => 'required|string|max:255',
            'policy_end_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $insurancePolicy = InsurancePolicy::findOrFail($id);
            $insurancePolicy->update([
                'insurance_type' => $request->insurance_type,
                'provider_name' => $request->provider_name,
                'policy_number' => $request->policy_number,
                'sum_insured' => $request->sum_insured,
                'contact_details' => $request->contact_details,
                'beneficiaries' => $request->beneficiaries,
                'policy_end_date' => $request->policy_end_date,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Insurance policy updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified insurance policy from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $insurancePolicy = InsurancePolicy::findOrFail($id);
            $insurancePolicy->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Insurance policy deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom insurance type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_insurance_type' => 'required|string|max:255|unique:insurance_types,name'
        ]);

        InsuranceTypes::create([
            'name' => $request->custom_insurance_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true], 200);
    }
}
