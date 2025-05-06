<?php

namespace App\Http\Controllers\Api\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\OnboardingProgress;
use App\Models\Picture;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class PictureController extends Controller
{
    use ImageUpload;

    /**
     * Get the list of pictures uploaded by the authenticated user.
     */
    public function view()
    {
        try {
            $pictures = Picture::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => $pictures
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created picture.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $path = $this->imageUpload($request->file('file'), 'pictures');

            $picture = Picture::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => Auth::id()
            ]);

            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['picture_uploaded' => true]
            );

            // If the record exists but picture_uploaded is false, update it
            if (!$progress->picture_uploaded) {
                $progress->picture_uploaded = true;
                $progress->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture added successfully.', 'data' => $picture], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified picture.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $picture = Picture::findOrFail($id);
            
            $picture->name = $request->name;
            $picture->description = $request->description;

            if ($request->hasFile('file')) {
                // Delete the old file from the public/assets/upload directory if exists
                $filePath = public_path('assets/upload/' . basename($picture->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'pictures');
                $picture->file_path = $path;
            }

            $picture->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture updated successfully.', 'data' => $picture], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a specific picture.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $picture = Picture::findOrFail($id);
            
            // Delete the file from the public/assets/upload directory if exists
            $filePath = public_path('assets/upload/' . basename($picture->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the picture record
            $picture->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
