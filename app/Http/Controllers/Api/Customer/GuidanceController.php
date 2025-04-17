<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Guidance;
use App\Models\GuidanceMedia;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class GuidanceController extends Controller
{
    use ImageUpload;

    /**
     * Display the guidance content for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            $guidance = Guidance::with('media')
                ->where('created_by', Auth::id())
                ->get();

            if ($guidance->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wish not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $guidance,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
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

            $filePath = public_path('assets/upload/' . $media->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

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
                'created_by' => Auth::id()
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $path = $this->imageUpload($uploadedFile, 'documents');

                    // If you have a media table, you can save it like:
                    $guidance->media()->create([
                        'file_path' => $path,
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
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    // Save file reference
                    GuidanceMedia::create([
                        'guidance_id' => $guidance->id,
                        'file_path' => $filename,
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
}
