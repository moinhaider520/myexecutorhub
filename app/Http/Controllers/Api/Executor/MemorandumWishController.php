<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\MemorandumWish;
use App\Models\MemorandumWishMedia;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class MemorandumWishController extends Controller
{
    /**
     * Display the wish content for the executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id): JsonResponse
    {
        try {
            // Get the currently authenticated executor
            $user = Auth::user();

            $wishes = MemorandumWish::with('media')
                ->where('created_by', $id)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $wishes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get media for a given wish.
     */
    public function getMedia($id): JsonResponse
    {
        try {
            $media = MemorandumWishMedia::where('memorandum_wish_id', $id)->get();

            return response()->json(['success' => true, 'data' => $media]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a specific media file.
     */
    public function deleteMedia($id): JsonResponse
    {
        try {
            $media = MemorandumWishMedia::findOrFail($id);
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
     * Store a new wish with media files.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Create the wish entry first
            $wish = MemorandumWish::create([
                'description' => $request->description,
                'created_by' => $request->created_by
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $path = $this->imageUpload($uploadedFile, 'documents');

                    // If you have a media table, you can save it like:
                    $wish->media()->create([
                        'file_path' => $path,
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Memorandum Wish created successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing wish.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'file.*' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $wish = MemorandumWish::findOrFail($id);
            $wish->description = $request->description;
            $wish->save();

            // Handle file upload (if any)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    // Save file reference
                    MemorandumWishMedia::create([
                        'memorandum_wish_id' => $wish->id,
                        'file_path' => $filename,

                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Memorandum Wish updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a wish and associated media.
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $document = MemorandumWish::findOrFail($id);
            $document->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Memorandum Wish deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
