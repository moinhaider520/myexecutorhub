<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\DocumentLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Use the 'created_by' field to get the related data
            $createdById = $user->created_by;

            // Fetch totals specific to the user's 'created_by' ID
            $totalExecutors = User::role('executor')->where('created_by', $createdById)->count();
            $totalDocuments = Document::where('created_by', $createdById)->count();
            $totalBankBalance = BankAccount::where('created_by', $createdById)->sum('balance');
            $totalDebt = DebtAndLiability::where('created_by', $createdById)->sum('amount_outstanding');
            $documentLocations = DocumentLocation::where('created_by', $user->created_by)->get();

            // Return the data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'total_executors' => $totalExecutors,
                    'total_documents' => $totalDocuments,
                    'total_bank_balance' => $totalBankBalance,
                    'total_debt' => $totalDebt,
                    'documentLocations', $documentLocations
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
