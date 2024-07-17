<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvestmentAccountController extends Controller
{
    public function index()
    {
        $investmentAccounts = InvestmentAccount::where('created_by', Auth::id())->get();
        return view('customer.assets.investment_accounts', compact('investmentAccounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'investment_type' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'account_number' => 'required|string|unique:investment_accounts,account_number',
            'balance' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            InvestmentAccount::create([
                'investment_type' => $request->investment_type,
                'company_name' => $request->company_name,
                'account_number' => $request->account_number,
                'balance' => $request->balance,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Investment account added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'investment_type' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'account_number' => 'required|string',
            'balance' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $investmentAccount = InvestmentAccount::findOrFail($id);
            $investmentAccount->update([
                'investment_type' => $request->investment_type,
                'company_name' => $request->company_name,
                'account_number' => $request->account_number,
                'balance' => $request->balance,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Investment account updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $investmentAccount = InvestmentAccount::findOrFail($id);
            $investmentAccount->delete();
            DB::commit();
            return redirect()->route('customer.investment_accounts.view')->with('success', 'Investment account deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
