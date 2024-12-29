<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\LPAVideos;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
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
            $video->customer_id = $authId;
            $video->url = $videoUrl;
            $video->save();

            return response()->json(['message' => 'Video uploaded successfully!', 'url' => $videoUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload video: ' . $e->getMessage()], 500);
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
