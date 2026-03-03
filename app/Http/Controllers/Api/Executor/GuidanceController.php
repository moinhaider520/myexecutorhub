<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Guidance;
use App\Models\GuidanceMedia;
use App\Traits\CloudinaryUpload;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class GuidanceController extends Controller
{
    use CloudinaryUpload;
    /**
     * Display the guidance for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve the guidance created by the authenticated user's creator
            $guidance = Guidance::with('media')
                ->where('created_by', $id)
                ->get();

            // Return the guidance as a JSON response
            return response()->json([
                'success' => true,
                'data' => $guidance
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve guidance data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get the media files related to a guidance.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMedia($id): JsonResponse
    {
        try {
            $media = GuidanceMedia::where('guidance_id', $id)->get();

            return response()->json([
                'success' => true,
                'data' => $media,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a specific media file.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMedia($id): JsonResponse
    {
        try {
            $media = GuidanceMedia::findOrFail($id);
            $this->deleteStoredFile($media->file_path, $media->file_public_id);

            $media->delete();

            return response()->json(['success' => true, 'message' => 'Media deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store new guidance content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Create the guidance entry first
            $guidance = Guidance::create([
                'description' => $request->description,
                'created_by' => $request->created_by
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $upload = $this->uploadFileToCloud($uploadedFile, 'executorhub/guidance_media');

                    // If you have a media table, you can save it like:
                    $guidance->media()->create([
                        'file_path' => $upload['url'],
                        'file_public_id' => $upload['public_id'],
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Guidance created successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update guidance content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'file.*' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $guidance = Guidance::findOrFail($id);
            $guidance->description = $request->description;
            $guidance->save();

            // Handle file upload (if any)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $upload = $this->uploadFileToCloud($uploadedFile, 'executorhub/guidance_media');

                    // Save file reference
                    GuidanceMedia::create([
                        'guidance_id' => $guidance->id,
                        'file_path' => $upload['url'],
                        'file_public_id' => $upload['public_id'],
                        'file_type' => $uploadedFile->getClientMimeType(),
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Guidance updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a guidance entry.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $guidance = Guidance::findOrFail($id);
            $guidance->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Guidance deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
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
