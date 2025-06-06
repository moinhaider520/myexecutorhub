<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use App\Models\WishMedia;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishesController extends Controller
{
    use ImageUpload;
    /**
     * Display the wishes view.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $wish = Wish::where('created_by', Auth::id())->get();
        return view('partner.wishes.wishes', compact('wish'));
    }

    public function getMedia($id)
    {
        return WishMedia::where('wish_id', $id)->get();
    }

    public function deleteMedia($id)
    {
        $media = WishMedia::findOrFail($id);
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

            // Create the wish entry first
            $wish = Wish::create([
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            // Loop through and upload each file
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $path = $this->imageUpload($uploadedFile, 'documents');

                    // If you have a media table, you can save it like:
                    $wish->media()->create([
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
     * Update or create the wishes content.
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

            $wish = Wish::findOrFail($id);
            $wish->description = $request->description;
            $wish->save();

            // Handle file upload (if any)
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                    $uploadedFile->move(public_path('assets/upload'), $filename);

                    // Save file reference
                    WishMedia::create([
                        'wish_id' => $wish->id,
                        'file_path' => $filename,
                        
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Trust Wish updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $document = Wish::findOrFail($id);
            // Delete the document record
            $document->delete();
            DB::commit();
            return redirect()->route('partner.wishes.view')->with('success', 'Trust Wish deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}