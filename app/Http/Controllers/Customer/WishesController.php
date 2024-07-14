<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishesController extends Controller
{
    /**
     * Display the wishes view.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $wish = Wish::where('created_by', Auth::id())->first();
        return view('customer.wishes.wishes', compact('wish'));
    }

    /**
     * Update or create the wishes content.
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

            $wish = Wish::updateOrCreate(
                ['created_by' => Auth::id()],
                ['content' => $request->content]
            );

            DB::commit();
            return redirect()->route('customer.wishes.view')->with('success', 'Wishes updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}