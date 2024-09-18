<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
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

    public function show($id)
    {
        $reviews = Review::where('document_id', $id)->with('user')->get();
        return response()->json(['reviews' => $reviews]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this review.');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
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
