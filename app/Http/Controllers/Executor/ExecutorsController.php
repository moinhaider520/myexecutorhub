<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExecutorsController extends Controller
{
    public function view()
    {
       $contextUser = ContextHelper::user();
        $executors = $contextUser->executors;

        return view('executor.executors.executors', compact('executors'));
    }
}
