<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\WillVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LPAVideos;
class WillController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $wills = WillVideos::where('customer_id',  $user->created_by)->get();
        return view('executor.wills.index', compact('wills'));
    }
}
