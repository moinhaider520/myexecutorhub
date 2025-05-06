<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherTypeOfAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CustomDropDown;

class OtherTypeofAssetController extends Controller
{
    /**
     * Get the list of other assets and custom asset types for the authenticated user.
     */
    public function view()
    {
        try {
            $otherAssetTypes = CustomDropDown::where('created_by', Auth::id())
                ->where('category', 'other_type_of_assets')
                ->get();

            $otherAssets = OtherTypeOfAsset::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'other_assets' => $otherAssets,
                    'other_asset_types' => $otherAssetTypes
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created other asset.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $otherAsset = OtherTypeOfAsset::create([
                'asset_type' => $request->asset_type,
                'description' => $request->description,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset added successfully.', 'data' => $otherAsset], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified other asset.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $otherAsset = OtherTypeOfAsset::findOrFail($id);
            $otherAsset->update([
                'asset_type' => $request->asset_type,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset updated successfully.', 'data' => $otherAsset], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a specific other asset.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $otherAsset = OtherTypeOfAsset::findOrFail($id);
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
                'category' => 'other_type_of_assets',
            ]);

            return response()->json(['success' => true], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
