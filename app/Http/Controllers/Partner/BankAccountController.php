<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\BankAccount;
use App\Models\OnboardingProgress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BankType;

class BankAccountController extends Controller
{
    public function view()
    {
        $bankTypes = BankType::where('created_by', Auth::id())->get();
        $bankAccounts = BankAccount::where('created_by', Auth::id())->get();
        return view('partner.assets.bank_accounts', compact('bankAccounts', 'bankTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_type' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'sort_code' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
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
            return response()->json(['success' => true, 'message' => 'Bank account added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'account_type' => 'required|string|max:255',
            'bank_name' => 'required|numeric',
            'sort_code' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'balance' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $bankAccount = BankAccount::findOrFail($id);

            $bankAccount->account_type = $request->account_type;
            $bankAccount->bank_name = $request->bank_name;
            $bankAccount->sort_code = $request->sort_code;
            $bankAccount->account_name = $request->account_name;
            $bankAccount->account_number = $request->account_number;
            $bankAccount->balance = $request->balance;
            $bankAccount->created_by = Auth::id();

            $bankAccount->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Bank account updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $bankAccount = BankAccount::findOrFail($id);
            $bankAccount->delete();

            DB::commit();
            return redirect()->route('partner.bank_accounts.view')->with('success', 'Bank account deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_bank_type' => 'required|string|max:255|unique:bank_types,name'
        ]);

        BankType::create([
            'name' => $request->custom_bank_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
