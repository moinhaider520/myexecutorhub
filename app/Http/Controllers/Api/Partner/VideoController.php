<?php

namespace App\Http\Controllers\Api\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\CloudinaryUpload;

class VideoController extends Controller
{
    use CloudinaryUpload;

    /**
     * Get the list of videos uploaded by the authenticated user.
     */
    public function view()
    {
        try {
            $videos = Video::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => $videos
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created video.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/videos');

            $video = Video::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $upload['url'],
                'file_public_id' => $upload['public_id'],
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video added successfully.', 'data' => $video], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified video.
     */
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
                $this->deleteStoredFile($video->file_path, $video->file_public_id);

                $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/videos');
                $video->file_path = $upload['url'];
                $video->file_public_id = $upload['public_id'];
            }

            $video->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video updated successfully.', 'data' => $video], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a specific video.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $video = Video::findOrFail($id);
            $this->deleteStoredFile($video->file_path, $video->file_public_id);

            // Delete the video record
            $video->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function deleteStoredFile(?string $path, ?string $publicId): void
    {
        if (!empty($publicId)) {
            $this->deleteFromCloud($publicId);
            return;
        }

        if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        $filePath = public_path('assets/upload/' . basename($path));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
