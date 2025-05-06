<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForeignAssets;
use App\Models\CustomDropDown;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForeignAssetsController extends Controller
{
    public function index()
    {
        $foreignAssets = ForeignAssets::where('created_by', Auth::id())->get();
        $assetTypes = CustomDropDown::where('created_by', Auth::id())
            ->where('category', 'foreign_assets')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'foreign_assets' => $foreignAssets,
                'asset_types' => $assetTypes
            ]
        ]);
    }

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
            return response()->json(['success' => true, 'message' => 'Foreign Asset added successfully.', 'data' => $foreignAsset]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // PUT /api/customer/foreign-assets/{id}
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

            $foreignAsset = ForeignAssets::where('created_by', Auth::id())->findOrFail($id);

            $foreignAsset->update([
                'foreign_asset' => $request->foreign_asset,
                'asset_type' => $request->asset_type,
                'asset_location' => $request->asset_location,
                'asset_value' => $request->asset_value,
                'contact_details' => $request->contact_details,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Foreign Asset updated successfully.', 'data' => $foreignAsset]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $foreignAsset = ForeignAssets::where('created_by', Auth::id())->findOrFail($id);
            $foreignAsset->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Foreign Asset deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_asset_type' => 'required|string|max:255|unique:custom_drop_downs,name'
        ]);

        $customType = CustomDropDown::create([
            'name' => $request->custom_asset_type,
            'created_by' => Auth::id(),
            'category' => 'foreign_assets',
        ]);

        return response()->json(['success' => true, 'message' => 'Custom asset type saved.', 'data' => $customType]);
    }
}
