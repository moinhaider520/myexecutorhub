<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\DebtAndLiabilitiesTypes;
use App\Models\DebtAndLiability;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class DebtAndLiabilityController extends Controller
{
    /**
     * Display the debts and liabilities for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve debt and liability types and records created by the authenticated user's creator
            $debtAndLiabilitiesTypes = DebtAndLiabilitiesTypes::where('created_by', $id)->get();
            $debtsLiabilities = DebtAndLiability::where('created_by', $id)->get();

            // Return the debts and liabilities data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'debts_liabilities' => $debtsLiabilities,
                    'debt_and_liabilities_types' => $debtAndLiabilitiesTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve debts and liabilities',
                'error' => $e->getMessage(),
            ], 500);
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
                'created_by' => $request->created_by,
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
            'custom_debt_and_liabilities_type' => 'required'
        ]);

        try {
            DebtAndLiabilitiesTypes::create([
                'name' => $request->custom_debt_and_liabilities_type,
                'created_by' => $request->created_by,
            ]);

            return response()->json(['success' => true, 'message' => 'Custom debt and liabilities type added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
