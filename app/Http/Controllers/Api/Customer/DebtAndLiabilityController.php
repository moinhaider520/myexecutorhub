<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DebtAndLiability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DebtAndLiabilitiesTypes;

class DebtAndLiabilityController extends Controller
{
    /**
     * Display a list of debts and liabilities for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $debtandliabilitiesTypes = DebtAndLiabilitiesTypes::where('created_by', Auth::id())->get();
            $debtsLiabilities = DebtAndLiability::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'debtsLiabilities' => $debtsLiabilities,
                'debtandliabilitiesTypes' => $debtandliabilitiesTypes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created debt and liability in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'debt_type' => 'required|string|max:255',
            'reference_number' => 'required|string|max:255',
            'loan_provider' => 'required|string|max:255',
            'contact_details' => 'required|string|max:255',
            'amount_outstanding' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            DebtAndLiability::create([
                'debt_type' => $request->debt_type,
                'reference_number' => $request->reference_number,
                'loan_provider' => $request->loan_provider,
                'contact_details' => $request->contact_details,
                'amount_outstanding' => $request->amount_outstanding,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Debt & Liability added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified debt and liability in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'debt_type' => 'required|string|max:255',
            'reference_number' => 'required|string|max:255',
            'loan_provider' => 'required|string|max:255',
            'contact_details' => 'required|string|max:255',
            'amount_outstanding' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $debtLiability = DebtAndLiability::findOrFail($id);
            $debtLiability->update([
                'debt_type' => $request->debt_type,
                'reference_number' => $request->reference_number,
                'loan_provider' => $request->loan_provider,
                'contact_details' => $request->contact_details,
                'amount_outstanding' => $request->amount_outstanding,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Debt & Liability updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified debt and liability from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $debtLiability = DebtAndLiability::findOrFail($id);
            $debtLiability->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Debt & Liability deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom debt and liabilities type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_debt_and_liabilities_type' => 'required|string|max:255|unique:debt_and_liabilities_types,name'
        ]);

        try {
            DebtAndLiabilitiesTypes::create([
                'name' => $request->custom_debt_and_liabilities_type,
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom debt and liabilities type added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
