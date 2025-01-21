<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Models\BankAccount;
use App\Models\OnboardingProgress;
use App\Models\DebtAndLiability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display the partner dashboard data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Fetch totals specific to the authenticated user
            $totalExecutors = User::role('executor')->where('created_by', $user->id)->count();
            $totalDocuments = Document::where('created_by', $user->id)->count();
            $totalBankBalance = BankAccount::where('created_by', $user->id)->sum('balance');
            $totalDebt = DebtAndLiability::where('created_by', $user->id)->sum('amount_outstanding');

            $progress = OnboardingProgress::where('user_id', $user->id)->first();

            $guide = [
                'Add at Least One Executor' => $progress->executor_added ?? false,
                'Add at Least One Bank Account' => $progress->bank_account_added ?? false,
                'Add at Least One Digital Asset' => $progress->digital_asset_added ?? false,
                'Add at Least One Property Owned' => $progress->property_added ?? false,
                'Upload at Least One Document' => $progress->document_uploaded ?? false,
            ];

            // Return the data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'total_executors' => $totalExecutors,
                    'total_documents' => $totalDocuments,
                    'total_bank_balance' => $totalBankBalance,
                    'total_debt' => $totalDebt,
                    'guide' => $guide,
                ]
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dashboard data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
