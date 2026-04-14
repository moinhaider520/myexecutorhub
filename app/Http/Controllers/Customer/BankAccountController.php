<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankType;
use App\Models\OnboardingProgress;
use App\Services\BankStatementPythonApiService;
use App\Services\MoneyhubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            Log::error('Moneyhub connection start failed.', [
                'user_id' => Auth::id(),
                'message' => $throwable->getMessage(),
            ]);

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
        Log::info('Moneyhub callback controller hit.', [
            'user_id' => Auth::id(),
            'has_error' => $request->filled('error'),
            'has_code' => $request->filled('code'),
            'has_state' => $request->filled('state'),
            'has_id_token' => $request->filled('id_token'),
        ]);

        if ($request->filled('error')) {
            $description = $request->input('error_description') ?: $request->input('error');

            Log::warning('Moneyhub callback returned provider error.', [
                'user_id' => Auth::id(),
                'error' => $request->input('error'),
                'error_description' => $request->input('error_description'),
            ]);

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
            Log::error('Moneyhub callback handling failed.', [
                'user_id' => Auth::id(),
                'message' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ]);

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

    public function uploadStatement(Request $request, BankStatementPythonApiService $bankStatementPythonApiService)
    {
        $request->validate([
            'bank_statement' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $extractedData = $bankStatementPythonApiService->extract($request->file('bank_statement'));

            $sortCode = $this->normalizeSortCode($extractedData['sort_code'] ?? null);
            $accountNumber = $this->normalizeAccountNumber($extractedData['account_number'] ?? null);
            $balance = $this->normalizeBalance($extractedData['available_balance'] ?? null);

            if (!$sortCode || !$accountNumber) {
                throw new \RuntimeException('The bank statement did not return a valid sort code and account number.');
            }

            if ($balance === null) {
                throw new \RuntimeException('The bank statement did not return a valid available balance.');
            }

            $bankAccount = BankAccount::where('created_by', Auth::id())
                ->get()
                ->first(function (BankAccount $account) use ($sortCode, $accountNumber) {
                    return $this->normalizeSortCode($account->sort_code) === $sortCode
                        && $this->normalizeAccountNumber($account->account_number) === $accountNumber;
                });

            if ($bankAccount) {
                $bankAccount->balance = $balance;
                $bankAccount->save();
                $message = 'Bank account balance updated successfully from the uploaded statement.';
            } else {
                BankAccount::create([
                    'account_type' => $extractedData['account_type'] ?? 'Personal',
                    'bank_name' => $extractedData['bank_name'] ?? 'Unknown Bank',
                    'sort_code' => $extractedData['sort_code'],
                    'account_name' => $extractedData['account_name'] ?? 'Unknown Account Name',
                    'account_number' => $extractedData['account_number'],
                    'balance' => $balance,
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

                $message = 'Bank account created successfully from the uploaded statement.';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $extractedData,
            ]);
        } catch (Throwable $throwable) {
            DB::rollBack();

            Log::error('Bank statement upload failed.', [
                'user_id' => Auth::id(),
                'message' => $throwable->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $throwable->getMessage(),
            ], $this->bankStatementErrorStatus($throwable));
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

    private function normalizeSortCode(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $normalized = preg_replace('/\D+/', '', $value);

        return $normalized !== '' ? $normalized : null;
    }

    private function normalizeAccountNumber(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $normalized = preg_replace('/\s+/', '', $value);

        return $normalized !== '' ? $normalized : null;
    }

    private function normalizeBalance($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        $normalized = preg_replace('/[^\d.\-]/', '', (string) $value);

        return is_numeric($normalized) ? (float) $normalized : null;
    }

    private function bankStatementErrorStatus(Throwable $throwable): int
    {
        $message = $throwable->getMessage();

        if (str_contains($message, 'temporarily busy') || str_contains($message, 'temporarily unavailable')) {
            return 503;
        }

        return 500;
    }
}
