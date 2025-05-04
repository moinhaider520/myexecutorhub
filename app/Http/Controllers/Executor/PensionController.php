<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\Pension;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PensionController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $pensions = Pension::where('created_by', $user->created_by)->get();
        return view('executor.pensions.view', compact('pensions'));
    }
}
