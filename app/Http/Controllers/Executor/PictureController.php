<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\OnboardingProgress;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class PictureController extends Controller
{
    use ImageUpload;
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        $pictures = Picture::whereIn('created_by', $userIds)->get();
        return view('executor.pictures.pictures', compact('pictures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|array|min:1',
            'file.*' => 'required|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        try {
            DB::beginTransaction();

            // Upload all files and store paths in an array
            $filePaths = [];
            foreach ($request->file('file') as $file) {
                $path = $this->imageUpload($file, 'pictures');
                $filePaths[] = $path;
            }

            // Store paths as JSON in the database
            Picture::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => json_encode($filePaths), // Store as JSON array
                'created_by' => ContextHelper::user()->id
            ]);

            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => ContextHelper::user()->id],
                ['picture_uploaded' => true]
            );

            // If the record exists but picture_uploaded is false, update it
            if (!$progress->picture_uploaded) {
                $progress->picture_uploaded = true;
                $progress->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pictures added successfully.']);
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
            'file' => 'nullable|array',
            'file.*' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $picture = Picture::findOrFail($id);

            $picture->name = $request->name;
            $picture->description = $request->description;

            if ($request->hasFile('file')) {
                // Delete old files from the public/assets/upload directory
                $oldPaths = json_decode($picture->file_path, true);
                if (is_array($oldPaths)) {
                    foreach ($oldPaths as $oldPath) {
                        $filePath = public_path('assets/upload/' . basename($oldPath));
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                } else {
                    // Handle single file path (backward compatibility)
                    $filePath = public_path('assets/upload/' . basename($picture->file_path));
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Upload new files
                $filePaths = [];
                foreach ($request->file('file') as $file) {
                    $path = $this->imageUpload($file, 'pictures');
                    $filePaths[] = $path;
                }

                $picture->file_path = json_encode($filePaths);
            }

            $picture->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pictures updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $picture = Picture::findOrFail($id);

            // Delete the file from the public/assets/upload directory
            $filePath = public_path('assets/upload/' . basename($picture->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the picture record
            $picture->delete();

            DB::commit();
            return redirect()->route('executor.pictures.view')->with('success', 'Picture deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
