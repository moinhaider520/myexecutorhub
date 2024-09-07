<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\Guidance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class GuidanceController extends Controller
{
    /**
     * Display the guidance content for the authenticated partner.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            // Retrieve guidance created by the authenticated partner
            $guidance = Guidance::where('created_by', Auth::id())->first();

            if (!$guidance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guidance not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $guidance
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update or create the guidance content for the authenticated partner.
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

            // Update or create guidance content for the authenticated user
            $guidance = Guidance::updateOrCreate(
                ['created_by' => Auth::id()],
                ['content' => $request->content]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Guidance updated successfully',
                'data' => $guidance
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
