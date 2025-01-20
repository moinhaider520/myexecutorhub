<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OtherAssetsTypes;

class OtherAssetController extends Controller
{
    /**
     * Display a list of other assets for the authenticated Partner.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $otherAssetTypes = OtherAssetsTypes::where('created_by', Auth::id())->get();
            $otherAssets = OtherAsset::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'otherAssets' => $otherAssets, 'otherAssetTypes' => $otherAssetTypes], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
                'created_by' => Auth::id(),
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
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom asset type added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
