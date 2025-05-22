<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LifeRememberedVideo;

class LifeRememberedVideoController extends Controller
{
    /**
     * Display the list of Life Remembered videos for the executor.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $lifeRememberedVideos = LifeRememberedVideo::where('created_by', $user->created_by)->get();
        return view('executor.life_remembered.life_remembered_videos', compact('lifeRememberedVideos'));
    }
}
