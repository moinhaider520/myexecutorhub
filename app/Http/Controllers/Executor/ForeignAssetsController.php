<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\ForeignAssets;
use Illuminate\Support\Facades\Auth;

class ForeignAssetsController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $contextUser = ContextHelper::user();
        $foreignAssets = ForeignAssets::where('created_by', $contextUser->id)->get();

        return view('executor.foreign_assets.view', compact('foreignAssets'));
    }
}
