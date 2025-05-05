<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FuneralPlan;

class FuneralPlanController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $funeralPlans = FuneralPlan::where('created_by', $user->created_by)->get();
        return view('executor.funeral_plans.view', compact('funeralPlans'));
    }
}