<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DebtAndLiabilitiesTypes;
use App\Models\DebtAndLiability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtAndLiabilityController extends Controller
{
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        // Retrieve debt and liabilities types and debts/liabilities created by the authenticated user
        $debtAndLiabilitiesTypes = DebtAndLiabilitiesTypes::whereIn('created_by', $userIds)->get();

        $debtsLiabilities = DebtAndLiability::whereIn('created_by', $userIds)->get();

        return view('executor.assets.debt_and_liabilities', compact('debtsLiabilities', 'debtAndLiabilitiesTypes'));
    }
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
            return response()->json(['success' => true, 'message' => 'Debt & Liability added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
            return response()->json(['success' => true, 'message' => 'Debt & Liability updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $debtLiability = DebtAndLiability::findOrFail($id);
            $debtLiability->delete();
            DB::commit();
            return redirect()->route('executor.debt_and_liabilities.view')->with('success', 'Debt & Liability deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_debt_and_liabilities_type' => 'required|string|max:255|unique:debt_and_liabilities_types,name'
        ]);

        DebtAndLiabilitiesTypes::create([
            'name' => $request->custom_debt_and_liabilities_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
