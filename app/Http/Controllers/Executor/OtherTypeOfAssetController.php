<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomDropDown;
use App\Models\OtherTypeOfAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OtherTypeOfAssetController extends Controller
{
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();

        $otherAssetTypes = CustomDropDown::whereIn('created_by', $userIds)
            ->where('category', 'other_type_of_assets')
            ->get();

        $otherAssets = OtherTypeOfAsset::whereIn('created_by', $userIds)->get();
        return view('executor.assets.other_type_of_assets', compact('otherAssets', 'otherAssetTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            OtherTypeOfAsset::create([
                'asset_type' => $request->asset_type,
                'description' => $request->description,
                'created_by' => ContextHelper::user()->id,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Other Asset added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
            return response()->json(['success' => true, 'message' => 'Other Asset updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $otherAsset = OtherTypeOfAsset::findOrFail($id);
            $otherAsset->delete();
            DB::commit();
            return redirect()->route('executor.other_type_of_assets.view')->with('success', 'Other Asset deleted successfully.');
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
            'created_by' => ContextHelper::user()->id,
            'category' => 'other_type_of_assets',
        ]);

        return response()->json(['success' => true]);
    }
}
