<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\ForeignAssets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CustomDropDown;
use Illuminate\Http\Request;
class ForeignAssetsController extends Controller
{
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        $foreignAssets = ForeignAssets::whereIn('created_by', $userIds)->get();
        $assetTypes = CustomDropDown::whereIn('created_by', $userIds)
            ->where('category', 'foreign_assets')
            ->get();
        return view('executor.foreign_assets.view', compact('foreignAssets', 'assetTypes'));
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

            ForeignAssets::create([
                'foreign_asset' => $request->foreign_asset,
                'asset_type' => $request->asset_type,
                'asset_location' => $request->asset_location,
                'asset_value' => $request->asset_value,
                'contact_details' => $request->contact_details,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Foreign Asset added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
            return response()->json(['success' => true, 'message' => 'Foreign Asset updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
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
            return redirect()->route('executor.foreign_assets.view')->with('success', 'Foreign Asset deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_asset_type' => 'required|string|max:255|unique:custom_drop_downs,name'
        ]);

        CustomDropDown::create([
            'name' => $request->custom_asset_type,
            'created_by' => Auth::id(),
            'category' => 'foreign_assets',
        ]);

        return response()->json(['success' => true]);
    }
}
