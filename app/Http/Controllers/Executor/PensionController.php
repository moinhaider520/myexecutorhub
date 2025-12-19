<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\Pension;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PensionController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $pensions = Pension::where('created_by', $contextUser->id)->get();
        return view('executor.pensions.view', compact('pensions'));
    }
}
