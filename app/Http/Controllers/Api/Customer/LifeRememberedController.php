<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\LifeRemembered;
use App\Models\LifeRememberedMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;
use Illuminate\Http\JsonResponse;

class LifeRememberedController extends Controller
{
    use ImageUpload;

    /**
     * Display all life remembered entries for the authenticated user.
     */
    public function view(): JsonResponse
    {
        $lifeRemembered = LifeRemembered::where('created_by', Auth::id())->get();

        return response()->json([
            'success' => true,
            'data' => $lifeRemembered
        ], 200);
    }

       /**
     * Get media files for a life remembered entry.
     */
    public function getMedia($id): JsonResponse
    {
        $media = LifeRememberedMedia::where('life_remembered_id', $id)->get();

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
            $media = LifeRememberedMedia::findOrFail($id);

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
     * Store a new life remembered entry.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Create the lifeRemembered entry first
            $lifeRemembered = LifeRemembered::create([
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $path = $this->imageUpload($uploadedFile, 'documents');

                    // If you have a media table, you can save it like:
                    $lifeRemembered->media()->create([
                        'file_path' => $path,
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Life Remembered entry created successfully.',
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
     * Update a specific life remembered entry.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'file.*' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $lifeRemembered = LifeRemembered::findOrFail($id);
            $lifeRemembered->description = $request->description;
            $lifeRemembered->save();

            // Handle file upload (if any)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    // Save file reference
                    LifeRememberedMedia::create([
                        'life_remembered_id' => $lifeRemembered->id,
                        'file_path' => $filename,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Life Remembered entry updated successfully.',
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
     * Delete a life remembered entry.
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $document = LifeRemembered::findOrFail($id);
            $document->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Life Remembered entry deleted successfully.'
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
