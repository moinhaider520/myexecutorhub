<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherTypeOfAsset;
use App\Models\CustomDropDown;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OtherTypeOfAssetController extends Controller
{
    public function index()
    {
        try {
            $otherAssetTypes = CustomDropDown::where('created_by', Auth::id())
                ->where('category', 'other_type_of_assets')
                ->get();

            $otherAssets = OtherTypeOfAsset::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'other_asset_types' => $otherAssetTypes,
                    'other_assets' => $otherAssets
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve assets.'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            OtherTypeOfAsset::create([
                'asset_type' => $request->asset_type,
                'description' => $request->description,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $otherAsset = OtherTypeOfAsset::findOrFail($id);

            // Optional: check if this asset belongs to current user
            if ($otherAsset->created_by !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $otherAsset->update([
                'asset_type' => $request->asset_type,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $otherAsset = OtherTypeOfAsset::findOrFail($id);

            // Optional: check ownership
            if ($otherAsset->created_by !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $otherAsset->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_asset_type' => 'required|string|max:255|unique:custom_drop_downs,name',
        ]);

        try {
            CustomDropDown::create([
                'name' => $request->custom_asset_type,
                'created_by' => Auth::id(),
                'category' => 'other_type_of_assets',
            ]);

            return response()->json(['success' => true, 'message' => 'Custom asset type saved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
