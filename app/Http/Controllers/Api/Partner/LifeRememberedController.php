<?php

namespace App\Http\Controllers\Api\Partner;

use App\Models\LifeRemembered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class LifeRememberedController extends Controller
{
    /**
     * Display the life remembered content.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            // Get the life remembered content created by the authenticated user
            $lifeRemembered = LifeRemembered::where('created_by', Auth::id())->first();

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

    /**
     * Update or create the life remembered content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Update or create life remembered content for the authenticated user
            $lifeRemembered = LifeRemembered::updateOrCreate(
                ['created_by' => Auth::id()],
                ['content' => $request->content]
            );

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Life Remembered updated successfully.',
                'data' => $lifeRemembered
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
