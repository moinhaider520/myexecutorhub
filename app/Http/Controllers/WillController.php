<?php

namespace App\Http\Controllers;

use App\Models\WillVideos;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Validator;
class WillController extends Controller
{
    public function create($id)
    {      
        return view('customer.wills.mobile', compact('id'));
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'auth_id' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

try {
    $uploadedFile = $request->file('video');
    if (!$uploadedFile) {
        \Log::error('Video file not received.');
        return response()->json(['error' => 'No video file received.'], 400);
    }

    if (!$uploadedFile->isValid()) {
        \Log::error('Uploaded file is invalid.', ['error' => $uploadedFile->getErrorMessage()]);
        return response()->json(['error' => 'Invalid video file.'], 400);
    }

    \Log::info('File received:', [
        'name' => $uploadedFile->getClientOriginalName(),
        'size' => $uploadedFile->getSize(),
        'mime' => $uploadedFile->getMimeType(),
    ]);

    // Proceed with upload
    $uploadResult = (new UploadApi())->upload($uploadedFile->getRealPath(), [
        'resource_type' => 'video',
        'folder' => 'will_videos',
    ]);

    $videoUrl = $uploadResult['secure_url'];
    \Log::info('Video uploaded to Cloudinary:', ['url' => $videoUrl]);

    // Save video details in the database
    $video = new WillVideos();
    $video->customer_id = $request->auth_id;
    $video->url = $videoUrl;
    $video->save();

    return response()->json(['message' => 'Video uploaded successfully!', 'url' => $videoUrl]);
} catch (\Exception $e) {
    \Log::error('Failed to upload video:', ['error' => $e->getMessage()]);
    return response()->json(['error' => 'Failed to upload video.'], 500);
}

}
}
