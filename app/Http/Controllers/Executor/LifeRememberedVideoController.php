<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LifeRememberedVideo;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;
use App\Models\LifeRememberedVideoMedia;
use Illuminate\Http\Request;

class LifeRememberedVideoController extends Controller
{
    use ImageUpload;
    /**
     * Display the list of Life Remembered videos for the executor.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        $lifeRememberedVideos = LifeRememberedVideo::whereIn('created_by', $userIds)->get();
        return view('executor.life_remembered.life_remembered_videos', compact('lifeRememberedVideos'));
    }

    public function getMedia($id)
    {
        return LifeRememberedVideoMedia::where('life_remembered_video_id', $id)->get();
    }

    public function deleteMedia($id)
    {
        $media = LifeRememberedVideoMedia::findOrFail($id);
        $filePath = public_path('assets/upload/' . $media->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $media->delete();

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Create the lifeRememberedVideo entry first
            $lifeRememberedVideo = LifeRememberedVideo::create([
                'description' => $request->description,
                'created_by' => ContextHelper::user()->id
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $path = $this->imageUpload($uploadedFile, 'videos');

                    // Save video media
                    $lifeRememberedVideo->media()->create([
                        'file_path' => $path,
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Video entry added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update or create the life remembered video content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $lifeRememberedVideo = LifeRememberedVideo::findOrFail($id);
            $lifeRememberedVideo->description = $request->description;
            $lifeRememberedVideo->save();

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    LifeRememberedVideoMedia::create([
                        'life_remembered_video_id' => $lifeRememberedVideo->id,
                        'file_path' => $filename,
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Life Remembered Video updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $video = LifeRememberedVideo::findOrFail($id);

            foreach ($video->media as $media) {
                $filePath = public_path('assets/upload/' . $media->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $video->delete();
            DB::commit();
            return redirect()->route('customer.life_remembered_videos.view')->with('success', 'Video entry deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
