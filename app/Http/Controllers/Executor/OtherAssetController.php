<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherAssetsTypes;
use App\Models\OtherAsset;
use Illuminate\Support\Facades\Auth;

class OtherAssetController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve other asset types and other assets created by the authenticated user
        $otherAssetTypes = OtherAssetsTypes::where('created_by', $user->created_by)->get();
        $otherAssets = OtherAsset::where('created_by', $user->created_by)->get();
        
        return view('executor.assets.other_assets', compact('otherAssets', 'otherAssetTypes'));
    }
}
