<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceTypes;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;

class InsurancePolicyController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $insuranceTypes = InsuranceTypes::where('created_by', $contextUser->id)->get();
        $insurancePolicies = InsurancePolicy::where('created_by', $contextUser->id)->get();

        return view('executor.assets.insurance_policies', compact('insurancePolicies', 'insuranceTypes'));
    }
}
