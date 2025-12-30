<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\CustomDropDown;
use App\Models\ForeignAssets;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ForeignAssetsController extends Controller
{
    /**
     * Get the list of foreign assets for the authenticated user.
     */
    public function view($id)
    {
        try {
            $user = Auth::user();
            $foreignAssets = ForeignAssets::where('created_by', $id)->get();
            $type = CustomDropDown::where('category','foreign_assets')->where('created_by',$id)->get();

            return response()->json([
                'success' => true,
                'data' => $foreignAssets,
                'asset_types' => $type
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
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
                'created_by' => $request->created_by,
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

            $foreignAsset = ForeignAssets::findOrFail($id);
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
            'custom_asset_type' => 'required'
        ]);

        $customType = CustomDropDown::create([
            'name' => $request->custom_asset_type,
            'created_by' => $request->created_by,
            'category' => 'foreign_assets',
        ]);

        return response()->json(['success' => true, 'message' => 'Custom asset type saved.', 'data' => $customType]);
    }
}
