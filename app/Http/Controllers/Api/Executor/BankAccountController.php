<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\BankType;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class BankAccountController extends Controller
{
    /**
     * Display the bank accounts and types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve bank types and bank accounts created by the authenticated user's creator
            $bankTypes = BankType::where('created_by', $id)->get();
            $bankAccounts = BankAccount::where('created_by', $id)->get();

            // Return the bank accounts and types as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'bank_accounts' => $bankAccounts,
                    'bank_types' => $bankTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve bank accounts and types',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
