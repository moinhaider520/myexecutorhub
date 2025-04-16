<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wish;
use Illuminate\Support\Facades\Auth;

class WishesController extends Controller
{
    /**
     * Display the wishes view.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        // Retrieve wishes created by the authenticated user
        $wish = Wish::where('created_by', $user->created_by)->get();
        return view('executor.wishes.wishes', compact('wish'));
    }
}
