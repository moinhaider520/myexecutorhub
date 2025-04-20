<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use Illuminate\Support\Facades\Auth;

class WishesController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        // Retrieve wishes created by the authenticated user
        $wish = Wish::where('created_by', $user->created_by)->get();
        return view('others.wishes.wishes', compact('wish'));
    }
}
