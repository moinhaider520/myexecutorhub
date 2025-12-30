<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\OtherAssetsTypes;
use App\Models\OtherAsset;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class OtherAssetController extends Controller
{
    /**
     * Display the other assets for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve other asset types and other assets created by the authenticated user's creator
            $otherAssetTypes = OtherAssetsTypes::where('created_by', $id)->get();
            $otherAssets = OtherAsset::where('created_by', $id)->get();

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

    /**
     * Store a newly created other asset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            OtherAsset::create([
                'asset_type' => $request->asset_type,
                'description' => $request->description,
                'created_by' => $request->created_by,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset added successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified other asset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $otherAsset = OtherAsset::findOrFail($id);
            $otherAsset->update([
                'asset_type' => $request->asset_type,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified other asset.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $otherAsset = OtherAsset::findOrFail($id);
            $otherAsset->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom asset type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_asset_type' => 'required|string|max:255|unique:other_assets_types,name',
        ]);

        try {
            OtherAssetsTypes::create([
                'name' => $request->custom_asset_type,
                'created_by' => $request->created_by,
            ]);

            return response()->json(['success' => true, 'message' => 'Custom asset type added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
