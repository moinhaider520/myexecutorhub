<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;

class PictureController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $pictures = Picture::where('created_by',  $contextUser->id)->get();
        return view('executor.pictures.pictures', compact('pictures'));
    }
}
