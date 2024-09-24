<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\DigitalAsset;
use App\Models\DigitalAssetsTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DigitalAssetController extends Controller
{
    /**
     * Display a list of digital assets for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $digitalAssetsTypes = DigitalAssetsTypes::where('created_by', Auth::id())->get();
            $digitalAssets = DigitalAsset::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'digitalAssets' => $digitalAssets, 'digitalAssetsTypes' => $digitalAssetsTypes], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created digital asset in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Digital Asset added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified digital asset in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
            return response()->json(['success' => true, 'message' => 'Digital Asset updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified digital asset from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $digitalAsset = DigitalAsset::findOrFail($id);
            $digitalAsset->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Digital Asset deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom digital asset type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_digital_assets_type' => 'required|string|max:255|unique:digital_assets_types,name'
        ]);

        DigitalAssetsTypes::create([
            'name' => $request->custom_digital_assets_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Custom digital asset type saved successfully.'], 200);
    }
}
