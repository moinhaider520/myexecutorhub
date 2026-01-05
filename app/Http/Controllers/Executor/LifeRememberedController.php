<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\LifeRemembered;
use App\Models\LifeRememberedMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class LifeRememberedController extends Controller
{
    use ImageUpload;
    public function view()
    {
        $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        $lifeRemembered = LifeRemembered::whereIn('created_by', $userIds)->get();
        return view('executor.life_remembered.life_remembered', compact('lifeRemembered'));
    }


    public function getMedia($id)
    {
        return LifeRememberedMedia::where('life_remembered_id', $id)->get();
    }

    public function deleteMedia($id)
    {
        $media = LifeRememberedMedia::findOrFail($id);
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

            // Create the lifeRemembered entry first
            $lifeRemembered = LifeRemembered::create([
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $path = $this->imageUpload($uploadedFile, 'documents');

                    // If you have a media table, you can save it like:
                    $lifeRemembered->media()->create([
                        'file_path' => $path,
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
     * Update or create the life remembered content.
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

            $lifeRemembered = LifeRemembered::findOrFail($id);
            $lifeRemembered->description = $request->description;
            $lifeRemembered->save();

            // Handle file upload (if any)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    // Save file reference
                    LifeRememberedMedia::create([
                        'life_remembered_id' => $lifeRemembered->id,
                        'file_path' => $filename,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Life Remembered updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $document = LifeRemembered::findOrFail($id);
            // Delete the document record
            $document->delete();
            DB::commit();
            return redirect()->route('executor.life_remembered.view')->with('success', 'Entry deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
