<?php

namespace App\Http\Controllers\Executor;
use Illuminate\Support\Facades\Auth;
use App\Models\PicturesAndVideos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class PicturesAndVideosController extends Controller
{
        use ImageUpload; 
    public function view()
    {
        $user = Auth::user();
        $pictures_and_videos = PicturesAndVideos::where('created_by', $user->created_by)->get();
        return view('executor.pictures_and_videos.pictures_and_videos', compact('pictures_and_videos'));
    }
}
