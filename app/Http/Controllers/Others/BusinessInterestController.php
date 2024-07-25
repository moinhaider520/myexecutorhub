<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessTypes;
use App\Models\BusinessInterest;
use Illuminate\Support\Facades\Auth;

class BusinessInterestController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve business types and business interests created by the authenticated user
        $businessTypes = BusinessTypes::where('created_by', $user->created_by)->get();
        $businessInterests = BusinessInterest::where('created_by', $user->created_by)->get();
        
        return view('others.assets.business_interest', compact('businessInterests', 'businessTypes'));
    }
}
