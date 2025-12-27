<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Guidance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class GuidanceController extends Controller
{
    /**
     * Display the guidance for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve the guidance created by the authenticated user's creator
            $guidance = Guidance::with('media')
                ->where('created_by', $id)
                ->get();

            if ($guidance->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wish not found'
                ], 404);
            }

            if (!$guidance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guidance not found'
                ], 404);
            }

            // Return the guidance as a JSON response
            return response()->json([
                'success' => true,
                'data' => $guidance
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve guidance data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
