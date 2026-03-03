<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\OnboardingProgress;
use App\Models\PicturesAndVideos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\CloudinaryUpload;

class PicturesAndVideosController extends Controller
{
    use CloudinaryUpload;

    public function view()
    {
        try {
            $pictures_and_videos = PicturesAndVideos::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'data' => $pictures_and_videos], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/pictures_and_videos');

            $document = PicturesAndVideos::create([
                'name' => $request->document_type,
                'description' => $request->description,
                'file_path' => $upload['url'],
                'file_public_id' => $upload['public_id'],
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
            return response()->json(['success' => true, 'message' => 'Document added successfully.', 'data' => $document], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $document = PicturesAndVideos::findOrFail($id);

            $document->name = $request->document_type;
            $document->description = $request->description;

            if ($request->hasFile('file')) {
                $this->deleteStoredFile($document->file_path, $document->file_public_id);
                $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/pictures_and_videos');
                $document->file_path = $upload['url'];
                $document->file_public_id = $upload['public_id'];
            }

            $document->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'File updated successfully.', 'data' => $document], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $document = PicturesAndVideos::findOrFail($id);

            $this->deleteStoredFile($document->file_path, $document->file_public_id);

            // Delete the document record
            $document->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'File deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function deleteStoredFile(?string $path, ?string $publicId): void
    {
        if (!empty($publicId)) {
            $this->deleteFromCloud($publicId);
            return;
        }

        if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        $filePath = public_path('assets/upload/' . basename($path));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
