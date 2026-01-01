<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Traits\ImageUpload;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    use ImageUpload;
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

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $path = $this->imageUpload($request->file('file'), 'videos');

            $video = Video::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => $request->created_by
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video added successfully.', 'data' => $video]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'nullable|file|mimes:mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $video = Video::findOrFail($id);

            $video->name = $request->name;
            $video->description = $request->description;

            if ($request->hasFile('file')) {
                $filePath = public_path('assets/upload/' . basename($video->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'videos');
                $video->file_path = $path;
            }

            $video->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video updated successfully.', 'data' => $video]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $video = Video::findOrFail($id);

            $filePath = public_path('assets/upload/' . basename($video->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $video->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
