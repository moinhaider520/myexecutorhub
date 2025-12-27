<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\CustomDropDown;  
use App\Models\OtherTypeOfAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OtherTypeOfAssetController extends Controller
{
    /**
     * Get the list of other type of assets and their types for the authenticated user.
     */
    public function view($id)
    {
        try {
            $user = Auth::user();

            // Fetch custom drop-down types for 'other_type_of_assets' category
            $otherAssetTypes = CustomDropDown::where('created_by', $id)
                ->where('category', 'other_type_of_assets')
                ->get();

            // Fetch the other type of assets created by the authenticated user
            $otherAssets = OtherTypeOfAsset::where('created_by', $id)->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'other_asset_types' => $otherAssetTypes,
                    'other_assets' => $otherAssets
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
