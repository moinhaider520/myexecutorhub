<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\PicturesAndVideos;
use App\Models\OnboardingProgress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class PicturesAndVideosController extends Controller
{
    use ImageUpload;
    public function view()
    {
        $pictures_and_videos = PicturesAndVideos::where('created_by', Auth::id())->get();
        return view('partner.pictures_and_videos.pictures_and_videos', compact('pictures_and_videos'));
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

            $path = $this->imageUpload($request->file('file'), 'documents');

            PicturesAndVideos::create([
                'name' => $request->document_type,
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
            return response()->json(['success' => true, 'message' => 'Document added successfully.']);
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
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $document = PicturesAndVideos::findOrFail($id);

            $document->name = $request->document_type;
            $document->description = $request->description;
            $document->created_by = Auth::id();

            if ($request->hasFile('file')) {
                // Delete the file from the public/assets/upload directory
                $filePath = public_path('assets/upload/' . basename($document->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'documents');
                $document->file_path = $path;
            }

            $document->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'File updated successfully.']);
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
            // Delete the file from the public/assets/upload directory
            $filePath = public_path('assets/upload/' . basename($document->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the document record
            $document->delete();
            DB::commit();
            return redirect()->route('partner.pictures_and_videos.view')->with('success', 'File deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
