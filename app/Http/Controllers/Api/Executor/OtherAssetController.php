<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\OtherAssetsTypes;
use App\Models\OtherAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class OtherAssetController extends Controller
{
    /**
     * Display the other assets for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve other asset types and other assets created by the authenticated user's creator
            $otherAssetTypes = OtherAssetsTypes::where('created_by', $user->created_by)->get();
            $otherAssets = OtherAsset::where('created_by', $user->created_by)->get();

            // Return the other assets data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'other_assets' => $otherAssets,
                    'other_asset_types' => $otherAssetTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve other assets',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
