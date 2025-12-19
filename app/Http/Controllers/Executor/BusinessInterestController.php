<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessTypes;
use App\Models\BusinessInterest;
use Illuminate\Support\Facades\Auth;

class BusinessInterestController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $businessTypes = BusinessTypes::where('created_by', $contextUser->id)->get();
        $businessInterests = BusinessInterest::where('created_by', $contextUser->id)->get();

        return view('executor.assets.business_interest', compact('businessInterests', 'businessTypes'));
    }
}
