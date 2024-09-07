<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class WishesController extends Controller
{
    /**
     * Display the wish content for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            // Retrieve wish created by the authenticated customer
            $wish = Wish::where('created_by', Auth::id())->first();

            if (!$wish) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wish not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $wish
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update or create the wish content for the authenticated customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        // Validate request content
        $request->validate([
            'content' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Update or create wish content for the authenticated customer
            $wish = Wish::updateOrCreate(
                ['created_by' => Auth::id()],
                ['content' => $request->content]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Wishes updated successfully',
                'data' => $wish
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
