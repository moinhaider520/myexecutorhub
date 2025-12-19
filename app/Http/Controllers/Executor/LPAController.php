<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LPAVideos;

class LPAController extends Controller
{
    public function index()
    {
        $contextUser = ContextHelper::user();
        $lpas = LPAVideos::where('customer_id',  $contextUser->id)->get();
        return view('executor.lpa.index', compact('lpas'));
    }
}
