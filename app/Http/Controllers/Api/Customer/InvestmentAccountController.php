<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\InvestmentTypes;

class InvestmentAccountController extends Controller
{
    /**
     * Display a list of investment accounts and types for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $investmentTypes = InvestmentTypes::where('created_by', Auth::id())->get();
            $investmentAccounts = InvestmentAccount::where('created_by', Auth::id())->get();
            return response()->json([
                'success' => true, 
                'investmentAccounts' => $investmentAccounts, 
                'investmentTypes' => $investmentTypes
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created investment account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            return response()->json(['success' => true, 'message' => 'Investment account added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified investment account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
            return response()->json(['success' => true, 'message' => 'Investment account updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified investment account from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $investmentAccount = InvestmentAccount::findOrFail($id);
            $investmentAccount->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Investment account deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom investment type for the authenticated customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_investment_type' => 'required|string|max:255|unique:investment_types,name'
        ]);

        try {
            InvestmentTypes::create([
                'name' => $request->custom_investment_type,
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom investment type saved successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
