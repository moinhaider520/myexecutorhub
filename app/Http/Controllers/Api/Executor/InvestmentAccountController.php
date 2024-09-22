<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\InvestmentTypes;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class InvestmentAccountController extends Controller
{
    /**
     * Display the investment accounts and types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve investment types and investment accounts created by the authenticated user's creator
            $investmentTypes = InvestmentTypes::where('created_by', $user->created_by)->get();
            $investmentAccounts = InvestmentAccount::where('created_by', $user->created_by)->get();

            // Return the investment accounts and types as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'investment_accounts' => $investmentAccounts,
                    'investment_types' => $investmentTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve investment accounts and types',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
