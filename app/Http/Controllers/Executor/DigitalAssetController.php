<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DigitalAssetsTypes;
use App\Models\DigitalAsset;
use Illuminate\Support\Facades\Auth;

class DigitalAssetController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $contextUser = ContextHelper::user();
        // Retrieve digital asset types and digital assets created by the authenticated user
        $digitalAssetsTypes = DigitalAssetsTypes::where('created_by', $contextUser->id)->get();
        $digitalAssets = DigitalAsset::where('created_by', $contextUser->id)->get();

        return view('executor.assets.digital_assets', compact('digitalAssets', 'digitalAssetsTypes'));
    }
}
