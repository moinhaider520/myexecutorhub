<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceTypes;
use App\Models\InsurancePolicy;
use Illuminate\Support\Facades\Auth;

class InsurancePolicyController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve insurance types and insurance policies created by the authenticated user
        $insuranceTypes = InsuranceTypes::where('created_by', $user->created_by)->get();
        $insurancePolicies = InsurancePolicy::where('created_by', $user->created_by)->get();
        
        return view('others.assets.insurance_policies', compact('insurancePolicies', 'insuranceTypes'));
    }
}
