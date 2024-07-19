<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Guidance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuidanceController extends Controller
{
    /**
     * Display the guidance view.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $guidance = Guidance::where('created_by', Auth::id())->first();
        return view('customer.guidance.guidance', compact('guidance'));
    }

    /**
     * Update or create the guidance content.
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

            $guidance = Guidance::updateOrCreate(
                ['created_by' => Auth::id()],
                ['content' => $request->content]
            );

            DB::commit();
            return redirect()->route('guidance.view')->with('success', 'Guidance updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
