<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankType;
use App\Models\OnboardingProgress;
use App\Services\MoneyhubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class BankAccountController extends Controller
{
    public function view()
    {
        $bankTypes = BankType::where('created_by', Auth::id())->get();
        $bankAccounts = BankAccount::where('created_by', Auth::id())->latest()->get();

        return view('customer.assets.bank_accounts', compact('bankAccounts', 'bankTypes'));
    }

    public function connectMoneyhub(MoneyhubService $moneyhubService)
    {
        try {
            $url = $moneyhubService->beginConnection(Auth::user());

            return redirect()->away($url);
        } catch (Throwable $throwable) {
            return redirect()
                ->route('customer.bank_accounts.view')
                ->with('error', $throwable->getMessage());
        }
    }

    public function moneyhubCallback()
    {
        return view('customer.assets.moneyhub_callback');
    }

    public function handleMoneyhubCallback(Request $request, MoneyhubService $moneyhubService)
    {
        if ($request->filled('error')) {
            $description = $request->input('error_description') ?: $request->input('error');

            return redirect()
                ->route('customer.bank_accounts.view')
                ->with('error', 'Moneyhub could not connect the bank account. ' . $description);
        }

        $request->validate([
            'code' => 'required|string',
            'state' => 'required|string',
            'id_token' => 'nullable|string',
        ]);

        try {
            $stats = $moneyhubService->completeConnection(
                Auth::user(),
                $request->string('code')->toString(),
                $request->string('state')->toString(),
                $request->string('id_token')->toString() ?: null,
            );

            $parts = [];

            if ($stats['bank_accounts'] > 0) {
                $parts[] = $stats['bank_accounts'] . ' bank account(s)';
            }

            if ($stats['investment_accounts'] > 0) {
                $parts[] = $stats['investment_accounts'] . ' investment account(s)';
            }

            if ($stats['liabilities'] > 0) {
                $parts[] = $stats['liabilities'] . ' liabilit' . ($stats['liabilities'] === 1 ? 'y' : 'ies');
            }

            $message = 'Moneyhub bank connection completed successfully.';

            if ($parts !== []) {
                $message .= ' Synced ' . implode(', ', $parts) . '.';
            }

            return redirect()
                ->route('customer.bank_accounts.view')
                ->with('success', $message);
        } catch (Throwable $throwable) {
            return redirect()
                ->route('customer.bank_accounts.view')
                ->with('error', $throwable->getMessage());
        }
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
                'created_by' => Auth::id(),
            ]);

            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['bank_account_added' => true]
            );

            if (!$progress->bank_account_added) {
                $progress->bank_account_added = true;
                $progress->save();
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Bank account added successfully.']);
        } catch (Throwable $throwable) {
            DB::rollback();

            return response()->json(['success' => false, 'message' => $throwable->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
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
        } catch (Throwable $throwable) {
            DB::rollback();

            return response()->json(['success' => false, 'message' => $throwable->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $bankAccount = BankAccount::findOrFail($id);
            $bankAccount->delete();

            DB::commit();

            return redirect()->route('customer.bank_accounts.view')->with('success', 'Bank account deleted successfully.');
        } catch (Throwable $throwable) {
            DB::rollback();

            return redirect()->back()->with('error', $throwable->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_bank_type' => 'required|string|max:255|unique:bank_types,name',
        ]);

        BankType::create([
            'name' => $request->custom_bank_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
