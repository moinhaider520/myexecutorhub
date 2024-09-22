<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\DigitalAssetsTypes;
use App\Models\DigitalAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class DigitalAssetController extends Controller
{
    /**
     * Display the digital assets for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve digital asset types and digital assets created by the authenticated user's creator
            $digitalAssetsTypes = DigitalAssetsTypes::where('created_by', $user->created_by)->get();
            $digitalAssets = DigitalAsset::where('created_by', $user->created_by)->get();

            // Return the digital assets data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'digital_assets' => $digitalAssets,
                    'digital_assets_types' => $digitalAssetsTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve digital assets',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
