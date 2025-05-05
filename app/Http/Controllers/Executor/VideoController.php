<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $videos = Video::where('created_by', $user->created_by)->get();
        return view('executor.videos.videos', compact('videos'));
    }
}
