<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Guidance;
use App\Models\GuidanceMedia;
use App\Traits\CloudinaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuidanceController extends Controller
{
    use CloudinaryUpload;
    /**
     * Display the guidance view.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $guidance = Guidance::where('created_by', Auth::id())->get();
        return view('partner.guidance.guidance', compact('guidance'));
    }

    public function getMedia($id)
    {
        return GuidanceMedia::where('guidance_id', $id)->get();
    }

    public function deleteMedia($id)
    {
        $media = GuidanceMedia::findOrFail($id);
        $this->deleteStoredFile($media->file_path, $media->file_public_id);
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

            // Create the guidance entry first
            $guidance = Guidance::create([
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $upload = $this->uploadFileToCloud($uploadedFile, 'executorhub/guidance_media');

                    // If you have a media table, you can save it like:
                    $guidance->media()->create([
                        'file_path' => $upload['url'],
                        'file_public_id' => $upload['public_id'],
                        'file_type' => $uploadedFile->getClientMimeType()
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Entry added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update or create the guidance content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'file.*' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $guidance = Guidance::findOrFail($id);
            $guidance->description = $request->description;
            $guidance->save();

            // Handle file upload (if any)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $upload = $this->uploadFileToCloud($uploadedFile, 'executorhub/guidance_media');

                    // Save file reference
                    GuidanceMedia::create([
                        'guidance_id' => $guidance->id,
                        'file_path' => $upload['url'],
                        'file_public_id' => $upload['public_id'],
                        'file_type' => $uploadedFile->getClientMimeType(),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Guidance updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $document = Guidance::findOrFail($id);
            // Delete the document record
            $document->delete();
            DB::commit();
            return redirect()->route('partner.guidance.view')->with('success', 'Guidance deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
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
