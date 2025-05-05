<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;

class PictureController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $pictures = Picture::where('created_by',  $user->created_by)->get();
        return view('others.pictures.pictures', compact('pictures'));
    }
}
