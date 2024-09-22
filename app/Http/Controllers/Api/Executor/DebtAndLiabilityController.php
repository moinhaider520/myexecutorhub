<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\DebtAndLiabilitiesTypes;
use App\Models\DebtAndLiability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class DebtAndLiabilityController extends Controller
{
    /**
     * Display the debts and liabilities for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve debt and liability types and records created by the authenticated user's creator
            $debtAndLiabilitiesTypes = DebtAndLiabilitiesTypes::where('created_by', $user->created_by)->get();
            $debtsLiabilities = DebtAndLiability::where('created_by', $user->created_by)->get();

            // Return the debts and liabilities data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'debts_liabilities' => $debtsLiabilities,
                    'debt_and_liabilities_types' => $debtAndLiabilitiesTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve debts and liabilities',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
