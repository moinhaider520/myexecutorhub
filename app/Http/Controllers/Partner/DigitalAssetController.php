<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnboardingProgress;
use App\Models\DigitalAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DigitalAssetsTypes;

class DigitalAssetController extends Controller
{
    public function view()
    {
        $digitalAssetsTypes = DigitalAssetsTypes::where('created_by', Auth::id())->get();
        $digitalAssets = DigitalAsset::where('created_by', Auth::id())->get();
        return view('partner.assets.digital_assets', compact('digitalAssets', 'digitalAssetsTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'asset_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'email_used' => 'required|string|email|max:255',
            'value' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            DigitalAsset::create([
                'asset_type' => $request->asset_type,
                'asset_name' => $request->asset_name,
                'username' => $request->username,
                'password' => $request->password,
                'email_used' => $request->email_used,
                'value' => $request->value,
                'created_by' => Auth::id(),
            ]);

            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['digital_asset_added' => true]
            );

            // If the record exists but digital_asset_added is false, update it
            if (!$progress->digital_asset_added) {
                $progress->digital_asset_added = true;
                $progress->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Digital Asset added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'asset_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'email_used' => 'required|string|email|max:255',
            'value' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $digitalAsset = DigitalAsset::findOrFail($id);
            $digitalAsset->update([
                'asset_type' => $request->asset_type,
                'asset_name' => $request->asset_name,
                'username' => $request->username,
                'password' => $request->password,
                'email_used' => $request->email_used,
                'value' => $request->value,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Digital Asset updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $digitalAsset = DigitalAsset::findOrFail($id);
            $digitalAsset->delete();
            DB::commit();
            return redirect()->route('partner.digital_assets.view')->with('success', 'Digital Asset deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_digital_assets_type' => 'required|string|max:255|unique:digital_assets_types,name'
        ]);

        DigitalAssetsTypes::create([
            'name' => $request->custom_digital_assets_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
