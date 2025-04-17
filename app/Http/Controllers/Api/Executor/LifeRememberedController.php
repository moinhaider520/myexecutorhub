<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LifeRemembered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LifeRememberedController extends Controller
{
    /**
     * Display the life remembered content for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();
            
            
            $lifeRemembered = LifeRemembered::with('media')
                ->where('created_by', $user->created_by)
                ->get();
            
            if (!$lifeRemembered) {
                return response()->json([
                    'success' => false,
                    'message' => 'Life remembered content not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $lifeRemembered
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
