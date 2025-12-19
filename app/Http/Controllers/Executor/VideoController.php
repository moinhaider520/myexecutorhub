<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $videos = Video::where('created_by', $contextUser->id)->get();
        return view('executor.videos.videos', compact('videos'));
    }
}
