<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'description' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $signaturePath = null;
            if ($request->signature_image) {
                $signaturePath = $this->uploadSignatureImage($request->signature_image); // Custom method for handling base64 image data
            }

            Review::create([
                'user_id' => Auth::id(),
                'document_id' => $request->document_id,
                'description' => $request->description,
                'signature_image' => $signaturePath,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Review added successfully.',
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add review.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display reviews for a specific document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $reviews = Review::where('document_id', $id)->with('user')->get();
            return response()->json([
                'success' => true,
                'data' => [
                    'reviews' => $reviews,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve reviews.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a review.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $review = Review::findOrFail($id);

            if ($review->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this review.',
                ], 403);
            }

            $review->delete();
            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload signature image.
     *
     * @param  string  $base64Image
     * @return string|null
     */
    private function uploadSignatureImage($base64Image)
    {
        // Remove the base64 data URL prefix
        $imageData = explode(',', $base64Image);
        $extension = explode(';', explode('/', $imageData[0])[1])[0];
        $image = base64_decode($imageData[1]);

        // Generate a unique file name and path
        $timestamp = time();
        $fileName = 'signature_' . $timestamp . '.' . $extension;
        $filePath = public_path('assets/upload/' . $fileName);

        // Save the image to the public directory
        file_put_contents($filePath, $image);

        return $fileName;
    }
}
