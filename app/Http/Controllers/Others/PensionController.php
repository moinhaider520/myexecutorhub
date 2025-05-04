<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\Pension;
use Illuminate\Support\Facades\Auth;

class PensionController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $pensions = Pension::where('created_by', $user->created_by)->get();
        return view('others.pensions.view', compact('pensions'));
    }
}
