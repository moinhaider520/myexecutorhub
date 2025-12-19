<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
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
        $contextUser = ContextHelper::user();
        $wish = Wish::where('created_by', $contextUser->id)->get();
        return view('executor.wishes.wishes', compact('wish'));
    }
}
