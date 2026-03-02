<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\OnboardingProgress;
use App\Models\Picture;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\CloudinaryUpload;

class PictureController extends Controller
{
    use CloudinaryUpload;

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
                $imagePath = $this->uploadToCloud($file, 'executorhub/pictures');
                $filePaths[] = [
                    'url' => $imagePath['url'],
                    'public_id' => $imagePath['public_id'],
                ];
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
            $existingFiles = $this->decodeStoredFiles($picture->getRawOriginal('file_path'));

            // Upload new files (append mode)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $imagePath = $this->uploadToCloud($file, 'executorhub/pictures');
                    $existingFiles[] = [
                        'url' => $imagePath['url'],
                        'public_id' => $imagePath['public_id'],
                    ];
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

            $oldPaths = $this->decodeStoredFiles($picture->getRawOriginal('file_path'));
            $this->deleteStoredFiles($oldPaths);

            $picture->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function decodeStoredFiles($storedFiles): array
    {
        if (is_array($storedFiles)) {
            return $storedFiles;
        }

        if (empty($storedFiles)) {
            return [];
        }

        $decoded = json_decode($storedFiles, true);
        return is_array($decoded) ? $decoded : [$storedFiles];
    }

    private function deleteStoredFiles(array $storedFiles): void
    {
        foreach ($storedFiles as $file) {
            if (is_array($file) && !empty($file['public_id'])) {
                $this->deleteFromCloud($file['public_id']);
                continue;
            }

            $path = is_array($file) ? ($file['url'] ?? null) : $file;
            if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
                continue;
            }

            $filePath = public_path('assets/upload/' . basename($path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
