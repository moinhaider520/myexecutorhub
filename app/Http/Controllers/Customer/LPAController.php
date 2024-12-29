<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\LPAVideos;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Validator;

class LPAController extends Controller
{
    public function index()
    {      
        return view('customer.lpa.index');
    }

    public function create()
    {      
        $authId = auth()->id();
        return view('customer.lpa.create', ['authId' => $authId]);
    }

    public function store(Request $request)
    {
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'video' => 'required|file|mimes:mp4|max:102400', // 100MB max size
            'auth_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Upload video to Cloudinary
        try {
            $uploadedFile = $request->file('video');
            $authId = $request->auth_id;

            $uploadResult = Cloudinary::uploadFile($uploadedFile->getRealPath(), [
                'resource_type' => 'video',
                'folder' => 'lpa_videos',
            ]);

            $videoUrl = $uploadResult->getSecurePath();

            // Save the video info in the database
            $video = new LPAVideos();
            $video->auth_id = $authId;
            $video->url = $videoUrl;
            $video->save();

            return response()->json(['message' => 'Video uploaded successfully!', 'url' => $videoUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload video: ' . $e->getMessage()], 500);
        }
    }
}
