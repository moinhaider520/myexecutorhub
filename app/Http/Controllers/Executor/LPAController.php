<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LPAVideos;

class LPAController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $lpas = LPAVideos::where('customer_id',  $user->created_by)->get();
        return view('executor.lpa.index', compact('lpas'));
    }
}
