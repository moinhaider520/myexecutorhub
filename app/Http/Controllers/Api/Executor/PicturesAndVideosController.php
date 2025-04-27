<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PicturesAndVideos;

class PicturesAndVideosController extends Controller
{
    public function view()
    {
        try {
            $user = Auth::user();
            $pictures_and_videos = PicturesAndVideos::where('created_by', $user->created_by)->get();
            return response()->json(['success' => true, 'data' => $pictures_and_videos], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
