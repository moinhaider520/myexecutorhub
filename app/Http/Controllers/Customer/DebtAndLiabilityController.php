<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DebtAndLiability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtAndLiabilityController extends Controller
{
    public function view()
    {
        $debtsLiabilities = DebtAndLiability::where('created_by', Auth::id())->get();
        return view('customer.assets.debt_and_liabilities', compact('debtsLiabilities'));
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
            return redirect()->route('customer.debt_and_liabilities.view')->with('success', 'Debt & Liability deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
