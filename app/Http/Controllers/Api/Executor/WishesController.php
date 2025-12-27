<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class WishesController extends Controller
{
    /**
     * Display the wish content for the executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id): JsonResponse
    {
        try {
            // Get the currently authenticated executor
            $user = Auth::user();

            $wishes = Wish::with('media')
                ->where('created_by', $id)
                ->get();

            if ($wishes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wish not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $wishes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
