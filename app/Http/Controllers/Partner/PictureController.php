<?php

namespace App\Http\Controllers\Partner;


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
    
    public function view()
    {
        $pictures = Picture::where('created_by', Auth::id())->get();
        return view('partner.pictures.pictures', compact('pictures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $imagePath = $this->uploadToCloud($request->file('file'), 'executorhub/pictures');
            $storedFiles = [[
                'url' => $imagePath['url'],
                'public_id' => $imagePath['public_id'],
            ]];

            Picture::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => json_encode($storedFiles),
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
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $picture = Picture::findOrFail($id);
            
            $picture->name = $request->name;
            $picture->description = $request->description;

            if ($request->hasFile('file')) {
                $oldPaths = $this->decodeStoredFiles($picture->getRawOriginal('file_path'));
                $this->deleteStoredFiles($oldPaths);

                $imagePath = $this->uploadToCloud($request->file('file'), 'executorhub/pictures');
                $picture->file_path = json_encode([[
                    'url' => $imagePath['url'],
                    'public_id' => $imagePath['public_id'],
                ]]);
            }

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
        try {
            DB::beginTransaction();
            $picture = Picture::findOrFail($id);

            $oldPaths = $this->decodeStoredFiles($picture->getRawOriginal('file_path'));
            $this->deleteStoredFiles($oldPaths);

            // Delete the picture record
            $picture->delete();
            
            DB::commit();
            return redirect()->route('partner.pictures.view')->with('success', 'Picture deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
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
