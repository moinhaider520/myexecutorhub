<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\LifeRemembered;
use Illuminate\Support\Facades\Auth;

class LifeRememberedController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $lifeRemembered = LifeRemembered::where('created_by', $contextUser->id)->get();
        return view('executor.life_remembered.life_remembered', compact('lifeRemembered'));
    }
}
