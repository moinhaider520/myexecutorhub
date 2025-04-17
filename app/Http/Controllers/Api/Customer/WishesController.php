<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use App\Models\WishMedia;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class WishesController extends Controller
{
    use ImageUpload;

    /**
     * Display the wish content for the authenticated customer.
     */
    public function view(): JsonResponse
    {
        try {
            $wish = Wish::where('created_by', Auth::id())->get();

            if (!$wish) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wish not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $wish
            ]);
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
            $media = WishMedia::where('wish_id', $id)->get();

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
            $media = WishMedia::findOrFail($id);
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
            $wish = Wish::create([
                'description' => $request->description,
                'created_by' => Auth::id()
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

            return response()->json(['success' => true, 'message' => 'Wish created successfully.']);
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

            $wish = Wish::findOrFail($id);
            $wish->description = $request->description;
            $wish->save();

            // Handle file upload (if any)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    // Save file reference
                    WishMedia::create([
                        'wish_id' => $wish->id,
                        'file_path' => $filename,
                        
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Wish updated successfully.']);
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
            $document = Wish::findOrFail($id);
            $document->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Wish deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
