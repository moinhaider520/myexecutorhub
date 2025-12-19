<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherAssetsTypes;
use App\Models\OtherAsset;
use Illuminate\Support\Facades\Auth;

class OtherAssetController extends Controller
{
    public function view()
    {
       $contextUser = ContextHelper::user();
        $otherAssetTypes = OtherAssetsTypes::where('created_by', $contextUser->id)->get();
        $otherAssets = OtherAsset::where('created_by', $contextUser->id)->get();

        return view('executor.assets.other_assets', compact('otherAssets', 'otherAssetTypes'));
    }
}
