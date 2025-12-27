<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LifeRememberedVideo;
use Illuminate\Http\JsonResponse;

class LifeRememberedVideoController extends Controller
{
    /**
     * Return a JSON list of Life Remembered videos for the executor.
     */
    public function view($id): JsonResponse
    {
        $user = Auth::user();

        // Fetch videos created by the original creator of the executor user
        $videos = LifeRememberedVideo::where('created_by', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $videos
        ]);
    }
}
