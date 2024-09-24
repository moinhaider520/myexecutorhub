<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class ReviewController extends Controller
{
    use ImageUpload;

    /**
     * Store a newly created review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'description' => 'required|string|max:255',
            'signature_image' => 'nullable|string', // Base64 encoded signature image
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
            return response()->json(['success' => true, 'message' => 'Review added successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'description' => 'required|string|max:255',
            'signature_image' => 'nullable|string', // Base64 encoded signature image
        ]);

        try {
            DB::beginTransaction();

            // Find the review
            $review = Review::findOrFail($id);

            // Update review details
            $review->document_id = $request->document_id;
            $review->description = $request->description;

            // Handle signature image update
            if ($request->signature_image) {
                $signaturePath = $this->uploadSignatureImage($request->signature_image); // Custom method for handling base64 image data
                $review->signature_image = $signaturePath; // Update the new image path
            }

            $review->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Review updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified review.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $review = Review::findOrFail($id);

            // Check if the review belongs to the authenticated user
            if ($review->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }

            $review->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Review deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a list of reviews for a specific document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $reviews = Review::where('document_id', $id)->with('user')->get();
            return response()->json(['success' => true, 'reviews' => $reviews], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Custom method to handle base64 image upload for signature.
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
