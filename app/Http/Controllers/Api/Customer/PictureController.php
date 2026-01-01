<?php

namespace App\Http\Controllers\Api\Customer;

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

    public function index()
    {
        try {
            $pictures = Picture::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => $pictures
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pictures.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $filePaths = [];
            foreach ($request->file('file') as $file) {
                $path = $this->imageUpload($file, 'pictures');
                $filePaths[] = $path;
            }

            Picture::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => json_encode($filePaths),
                'created_by' => Auth::id()
            ]);

            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['picture_uploaded' => true]
            );

            if (!$progress->picture_uploaded) {
                $progress->picture_uploaded = true;
                $progress->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $picture = Picture::findOrFail($id);

            $picture->name = $request->name;
            $picture->description = $request->description;

            // Existing files (JSON → array)
            $existingFiles = $picture->file_path
                ? json_decode($picture->file_path, true)
                : [];

            // Upload new files (append mode)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = $this->imageUpload($file, 'pictures');
                    $existingFiles[] = $path;
                }
            }

            // Save back as JSON
            $picture->file_path = json_encode($existingFiles);
            $picture->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $picture = Picture::findOrFail($id);

            // Optional: Check ownership
            if ($picture->created_by !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $filePath = public_path('assets/upload/' . basename($picture->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $picture->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
