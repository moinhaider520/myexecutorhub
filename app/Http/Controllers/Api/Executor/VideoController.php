<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Traits\CloudinaryUpload;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    use CloudinaryUpload;
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

            $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/videos');

            $video = Video::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $upload['url'],
                'file_public_id' => $upload['public_id'],
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
                $this->deleteStoredFile($video->file_path, $video->file_public_id);

                $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/videos');
                $video->file_path = $upload['url'];
                $video->file_public_id = $upload['public_id'];
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
            $this->deleteStoredFile($video->file_path, $video->file_public_id);

            $video->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
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
