<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\BusinessTypes;
use App\Models\BusinessInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class BusinessInterestController extends Controller
{
    /**
     * Display the business interests and business types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve business types and business interests created by the authenticated user's creator
            $businessTypes = BusinessTypes::where('created_by', $id)->get();
            $businessInterests = BusinessInterest::where('created_by', $id)->get();

            // Return the business interests and business types as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'business_interests' => $businessInterests,
                    'business_types' => $businessTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve business interests and types',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
