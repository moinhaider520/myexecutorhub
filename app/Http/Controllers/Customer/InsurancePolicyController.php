<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsurancePolicyController extends Controller
{
    public function index()
    {
        return view('customer.assets.insurance_policies');
    }
}
