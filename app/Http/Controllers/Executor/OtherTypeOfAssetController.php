<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomDropDown;  
use App\Models\OtherTypeOfAsset;
use Illuminate\Support\Facades\Auth;

class OtherTypeOfAssetController extends Controller
{
    public function view()
    {
        $user = Auth::user();

        $otherAssetTypes = CustomDropDown::where('created_by', $user->created_by)
            ->where('category', 'other_type_of_assets')
            ->get();

        $otherAssets = OtherTypeOfAsset::where('created_by', $user->created_by)->get();

        return view('executor.assets.other_type_of_assets', compact('otherAssets', 'otherAssetTypes'));
    }
}
