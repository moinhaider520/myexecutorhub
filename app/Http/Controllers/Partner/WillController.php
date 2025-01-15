<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\WillVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Cloudinary\Api\Upload\UploadApi;
use Validator;
class WillController extends Controller
{
    public function index()
    {      
        $wills = WillVideos::where('customer_id', Auth::id())->get();
        return view('partner.wills.index',compact('wills'));
    }

    public function create()
    {      
        $authId = auth()->id();
        return view('partner.wills.create', ['authId' => $authId]);
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


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $willVideo = WillVideos::findOrFail($id);
            $willVideo->delete();
            DB::commit();
            return redirect()->route('partner.wills.index')->with('success', 'Will deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
