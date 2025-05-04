<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\ForeignAssets;
use Illuminate\Support\Facades\Auth;

class ForeignAssetsController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $foreignAssets = ForeignAssets::where('created_by', $user->created_by)->get();

        return view('executor.foreign_assets.view', compact('foreignAssets'));
    }
}
