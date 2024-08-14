<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\InvestmentTypes;

class InvestmentAccountController extends Controller
{
    public function index()
    {
        $investmentTypes = InvestmentTypes::where('created_by', Auth::id())->get();
        $investmentAccounts = InvestmentAccount::where('created_by', Auth::id())->get();
        return view('partner.assets.investment_accounts', compact('investmentAccounts', 'investmentTypes'));
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
            return redirect()->route('partner.investment_accounts.view')->with('success', 'Investment account deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_investment_type' => 'required|string|max:255|unique:investment_types,name'
        ]);

        InvestmentTypes::create([
            'name' => $request->custom_investment_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
