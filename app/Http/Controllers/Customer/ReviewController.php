<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class ReviewController extends Controller
{
    use ImageUpload;

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
            return redirect()->back()->with('success', 'Review added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'description' => 'required|string|max:255',
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
            return redirect()->back()->with('success', 'Review updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $review = Review::findOrFail($id);

            // Check if the review belongs to the authenticated user
            if ($review->user_id !== Auth::id()) {
                return redirect()->back()->with('error', 'You are not authorized to delete this review.');
            }

            $review->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Review deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $reviews = Review::where('document_id', $id)->with('user')->get();
        return response()->json(['reviews' => $reviews]);
    }

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
