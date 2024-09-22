<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\InsuranceTypes;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class InsurancePolicyController extends Controller
{
    /**
     * Display the insurance policies and types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve insurance types and policies created by the authenticated user's creator
            $insuranceTypes = InsuranceTypes::where('created_by', $user->created_by)->get();
            $insurancePolicies = InsurancePolicy::where('created_by', $user->created_by)->get();

            // Return the insurance policies and types as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'insurance_policies' => $insurancePolicies,
                    'insurance_types' => $insuranceTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve insurance policies and types',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
