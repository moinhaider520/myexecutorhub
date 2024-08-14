<?php

namespace App\Http\Controllers\Partner;

use App\Models\LifeRemembered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LifeRememberedController extends Controller
{
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

            $lifeRemembered = LifeRemembered::updateOrCreate(
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
}
