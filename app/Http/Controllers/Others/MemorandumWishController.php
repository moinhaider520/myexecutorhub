<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\MemorandumWish;
use Illuminate\Support\Facades\Auth;

class MemorandumWishController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        // Retrieve memorandum_wishes created by the authenticated user
        $wish = MemorandumWish::where('created_by', $user->created_by)->get();
        return view('others.memorandum_wishes.memorandum_wishes', compact('wish'));
    }
}
