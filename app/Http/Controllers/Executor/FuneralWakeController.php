<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\FuneralWake;
use Illuminate\Support\Facades\Auth;

class FuneralWakeController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $contextUser = ContextHelper::user();
        $funeralwakes = FuneralWake::where('created_by', $contextUser->id)->get();

        return view('executor.funeral_wake.funeral_wake', compact('funeralwakes'));
    }
}
