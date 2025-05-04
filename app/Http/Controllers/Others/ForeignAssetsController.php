<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ForeignAssets;

class ForeignAssetsController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $foreignAssets = ForeignAssets::where('created_by', $user->created_by)->get();

        return view('others.foreign_assets.view', compact('foreignAssets'));
    }
}
