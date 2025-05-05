<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class VideoController extends Controller
{
    use ImageUpload;

    public function view()
    {
        $videos = Video::where('created_by', Auth::id())->get();
        return view('partner.videos.videos', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $path = $this->imageUpload($request->file('file'), 'videos');

            Video::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video added successfully.']);
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
            'file' => 'nullable|file|mimes:mp4,mov,avi,mkv|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $video = Video::findOrFail($id);
            
            $video->name = $request->name;
            $video->description = $request->description;

            if ($request->hasFile('file')) {
                $filePath = public_path('assets/upload/' . basename($video->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'videos');
                $video->file_path = $path;
            }

            $video->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $video = Video::findOrFail($id);

            $filePath = public_path('assets/upload/' . basename($video->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $video->delete();

            DB::commit();
            return redirect()->route('partner.videos.view')->with('success', 'Video deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
