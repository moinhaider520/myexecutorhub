<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;

class PictureController extends Controller
{
    /**
     * Get the list of pictures for the authenticated user.
     */
    public function view($id)
    {
        try {
            $user = Auth::user();
            $pictures = Picture::where('created_by', $id)->get();

            return response()->json([
                'success' => true,
                'data' => $pictures
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
