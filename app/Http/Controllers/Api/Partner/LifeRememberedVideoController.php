<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\LifeRememberedVideo;
use App\Models\LifeRememberedVideoMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Traits\ImageUpload;

class LifeRememberedVideoController extends Controller
{
    use ImageUpload;

    /**
     * Display all life remembered video entries for the authenticated user.
     */
    public function view(): JsonResponse
    {
        $lifeRememberedVideos = LifeRememberedVideo::with('media')
            ->where('created_by', Auth::id())
            ->get();

        return response()->json([
            'success' => true,
            'data' => $lifeRememberedVideos
        ], 200);
    }

    /**
     * Get media files for a life remembered video entry.
     */
    public function getMedia($id): JsonResponse
    {
        $media = LifeRememberedVideoMedia::where('life_remembered_video_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $media
        ]);
    }

    /**
     * Delete a specific media file.
     */
    public function deleteMedia($id): JsonResponse
    {
        try {
            $media = LifeRememberedVideoMedia::findOrFail($id);

            $filePath = public_path('assets/upload/' . $media->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $media->delete();

            return response()->json(['success' => true, 'message' => 'Media deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a new life remembered video entry.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $lifeRememberedVideo = LifeRememberedVideo::create([
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $path = $this->imageUpload($uploadedFile, 'videos');

                    $lifeRememberedVideo->media()->create([
                        'file_path' => $path,
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Video entry created successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a specific life remembered video entry.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'file.*' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $lifeRememberedVideo = LifeRememberedVideo::findOrFail($id);
            $lifeRememberedVideo->description = $request->description;
            $lifeRememberedVideo->save();

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    LifeRememberedVideoMedia::create([
                        'life_remembered_video_id' => $lifeRememberedVideo->id,
                        'file_path' => $filename,
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Video entry updated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a life remembered video entry.
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $video = LifeRememberedVideo::findOrFail($id);

            foreach ($video->media as $media) {
                $filePath = public_path('assets/upload/' . $media->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $video->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Video entry deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
