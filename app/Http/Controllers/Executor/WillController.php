<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\WillVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LPAVideos;
class WillController extends Controller
{
    public function index()
    {
        $contextUser = ContextHelper::user();
        $wills = WillVideos::where('customer_id',  $contextUser->id)->get();
        return view('executor.wills.index', compact('wills'));
    }
}
