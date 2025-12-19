<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FuneralPlan;

class FuneralPlanController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $contextUser = ContextHelper::user();
        $funeralPlans = FuneralPlan::where('created_by', $contextUser->id)->get();
        return view('executor.funeral_plans.view', compact('funeralPlans'));
    }
}
