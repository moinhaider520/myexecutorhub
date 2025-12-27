<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Get the list of videos for the authenticated user.
     */
    public function view($id)
    {
        try {
            $user = Auth::user();
            $videos = Video::where('created_by', $id)->get();

            return response()->json([
                'success' => true,
                'data' => $videos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
