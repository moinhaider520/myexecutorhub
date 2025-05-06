<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForeignAssets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CustomDropDown;

class ForeignAssetsController extends Controller
{
    /**
     * Get the list of foreign assets and custom asset types for the authenticated user.
     */
    public function view()
    {
        try {
            $assetTypes = CustomDropDown::where('created_by', Auth::id())
                ->where('category', 'foreign_assets')
                ->get();

            $foreignAssets = ForeignAssets::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'foreign_assets' => $foreignAssets,
                    'asset_types' => $assetTypes
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created foreign asset.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foreign_asset' => 'required|string|max:255',
            'asset_type' => 'required|string|max:255',
            'asset_location' => 'required|string|max:255',
            'asset_value' => 'required|string|max:255',
            'contact_details' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $foreignAsset = ForeignAssets::create([
                'foreign_asset' => $request->foreign_asset,
                'asset_type' => $request->asset_type,
                'asset_location' => $request->asset_location,
                'asset_value' => $request->asset_value,
                'contact_details' => $request->contact_details,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Foreign Asset added successfully.', 'data' => $foreignAsset], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified foreign asset.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'foreign_asset' => 'required|string|max:255',
            'asset_type' => 'required|string|max:255',
            'asset_location' => 'required|string|max:255',
            'asset_value' => 'required|string|max:255',
            'contact_details' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $foreignAsset = ForeignAssets::findOrFail($id);
            $foreignAsset->update([
                'foreign_asset' => $request->foreign_asset,
                'asset_type' => $request->asset_type,
                'asset_location' => $request->asset_location,
                'asset_value' => $request->asset_value,
                'contact_details' => $request->contact_details,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Foreign Asset updated successfully.', 'data' => $foreignAsset], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a specific foreign asset.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $foreignAsset = ForeignAssets::findOrFail($id);
            $foreignAsset->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Foreign Asset deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom asset type.
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_asset_type' => 'required|string|max:255|unique:custom_drop_downs,name'
        ]);

        try {
            CustomDropDown::create([
                'name' => $request->custom_asset_type,
                'created_by' => Auth::id(),
                'category' => 'foreign_assets',
            ]);

            return response()->json(['success' => true], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
