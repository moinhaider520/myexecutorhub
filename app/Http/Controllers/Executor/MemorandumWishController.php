<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\MemorandumWish;
use Illuminate\Support\Facades\Auth;

class MemorandumWishController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $wish = MemorandumWish::where('created_by', $contextUser->id)->get();
        return view('others.memorandum_wishes.memorandum_wishes', compact('wish'));
    }
}
