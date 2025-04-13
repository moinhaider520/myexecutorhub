<?php

namespace App\Http\Controllers\Partner;

use App\Models\LifeRemembered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class LifeRememberedController extends Controller
{
    use ImageUpload;
    /**
     * Display the life remembered view.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $lifeRemembered = LifeRemembered::where('created_by', Auth::id())->first();
        return view('partner.life_remembered.life_remembered', compact('lifeRemembered'));
    }

    /**
     * Update or create the life remembered content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        try {
            DB::beginTransaction();

            LifeRemembered::updateOrCreate(
                ['created_by' => Auth::id()],
                ['content' => $request->content]
            );

            DB::commit();
            return redirect()->route('partner.life_remembered.view')->with('success', 'Life Remembered updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle image uploads from CKEditor using ImageUpload trait.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            try {
                $filename = $this->imageUpload($request->file('upload'));
                $url = asset('assets/upload/' . $filename);

                return response()->json([
                    'url' => $url,
                    'uploaded' => true
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'uploaded' => false,
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ]);
            }
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'No file uploaded.'
            ]
        ]);
    }
}
