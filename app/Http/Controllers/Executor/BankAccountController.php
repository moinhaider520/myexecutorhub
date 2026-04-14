<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Services\BankStatementPythonApiService;
use Illuminate\Http\Request;
use App\Models\BankType;
use App\Models\BankAccount;
use App\Models\OnboardingProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BankAccountController extends Controller
{
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();

        $bankTypes = BankType::whereIn('created_by', $userIds)->get();
        $bankAccounts = BankAccount::whereIn('created_by', $userIds)->get();

        return view('executor.assets.bank_accounts', compact('bankAccounts', 'bankTypes'));
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
            $contextUser = ContextHelper::user();
            DB::beginTransaction();

            BankAccount::create([
                'account_type' => $request->account_type,
                'bank_name' => $request->bank_name,
                'sort_code' => $request->sort_code,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'balance' => $request->balance,
                'created_by' => $contextUser->id,
            ]);

            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => $contextUser->id],
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
            $bankAccount->created_by = ContextHelper::user()->id;

            $bankAccount->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Bank account updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function uploadStatement(Request $request, BankStatementPythonApiService $bankStatementPythonApiService)
    {
        $request->validate([
            'bank_statement' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        try {
            $contextUser = ContextHelper::user();

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

            $bankAccount = BankAccount::where('created_by', $contextUser->id)
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
                    'created_by' => $contextUser->id,
                ]);

                $progress = OnboardingProgress::firstOrCreate(
                    ['user_id' => $contextUser->id],
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

            Log::error('Executor bank statement upload failed.', [
                'user_id' => Auth::id(),
                'context_user_id' => ContextHelper::user()->id ?? null,
                'message' => $throwable->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $throwable->getMessage(),
            ], $this->bankStatementErrorStatus($throwable));
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $bankAccount = BankAccount::findOrFail($id);
            $bankAccount->delete();

            DB::commit();
            return redirect()->route('executor.bank_accounts.view')->with('success', 'Bank account deleted successfully.');
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
            'created_by' => ContextHelper::user()->id,
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
