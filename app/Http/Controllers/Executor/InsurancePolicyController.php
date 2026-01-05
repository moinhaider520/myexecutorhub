<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceTypes;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsurancePolicyController extends Controller
{
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        $insuranceTypes = InsuranceTypes::whereIn('created_by', $userIds)->get();
        $insurancePolicies = InsurancePolicy::whereIn('created_by', $userIds)->get();

        return view('executor.assets.insurance_policies', compact('insurancePolicies', 'insuranceTypes'));
    }

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
            return response()->json(['success' => true, 'message' => 'Insurance policy added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
            return response()->json(['success' => true, 'message' => 'Insurance policy updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $insurancePolicy = InsurancePolicy::findOrFail($id);
            $insurancePolicy->delete();
            DB::commit();
            return redirect()->route('customer.insurance_policies.view')->with('success', 'Insurance policy deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_insurance_type' => 'required|string|max:255|unique:insurance_types,name'
        ]);

        InsuranceTypes::create([
            'name' => $request->custom_insurance_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
