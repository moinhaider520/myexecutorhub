<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\BankAccount;
use App\Models\OnboardingProgress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BankType;

class BankAccountController extends Controller
{
    /**
     * Display a list of bank accounts for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $bankTypes = BankType::where('created_by', Auth::id())->get();
            $bankAccounts = BankAccount::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'bankAccounts' => $bankAccounts, 'bankTypes' => $bankTypes], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created bank account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_type' => 'required|string|max:255',
            'balance' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            BankAccount::create([
                'account_type' => $request->account_type,
                'bank_name' => $request->bank_name,
                'sort_code' => $request->sort_code,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'balance' => $request->balance,
                'created_by' => Auth::id()
            ]);

            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['bank_account_added' => true]
            );

            // If the record exists but bank_account_added is false, update it
            if (!$progress->bank_account_added) {
                $progress->bank_account_added = true;
                $progress->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Bank account added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified bank account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'account_type' => 'required|string|max:255',
            'balance' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $bankAccount = BankAccount::findOrFail($id);
            $bankAccount->update([
                'account_type' => $request->account_type,
                'bank_name' => $request->bank_name,
                'sort_code' => $request->sort_code,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'balance' => $request->balance,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Bank account updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified bank account from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $bankAccount = BankAccount::findOrFail($id);
            $bankAccount->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Bank account deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom bank type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_bank_type' => 'required|string|max:255|unique:bank_types,name'
        ]);

        BankType::create([
            'name' => $request->custom_bank_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true], 200);
    }
}
