<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\LPAVideos;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Cloudinary\Api\Upload\UploadApi;
use Validator;

class LPAController extends Controller
{
    public function index()
    {      
        $lpas = LPAVideos::where('customer_id', Auth::id())->get();
        return view('customer.lpa.index',compact('lpas'));
    }

    public function create()
    {      
        $authId = auth()->id();
        return view('customer.lpa.create', ['authId' => $authId]);
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
        'folder' => 'lpa_videos',
    ]);

    $videoUrl = $uploadResult['secure_url'];
    \Log::info('Video uploaded to Cloudinary:', ['url' => $videoUrl]);

    // Save video details in the database
    $video = new LPAVideos();
    $video->customer_id = $request->auth_id;
    $video->url = $videoUrl;
    $video->save();

    return response()->json(['message' => 'Video uploaded successfully!', 'url' => $videoUrl]);
} catch (\Exception $e) {
    \Log::error('Failed to upload video:', ['error' => $e->getMessage()]);
    return response()->json(['error' => 'Failed to upload video.'], 500);
}

}


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $lpaVideo = LPAVideos::findOrFail($id);
            $lpaVideo->delete();
            DB::commit();
            return redirect()->route('customer.lpa.index')->with('success', 'LPA deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
