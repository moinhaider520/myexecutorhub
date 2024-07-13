<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebtAndLiabilitiesController extends Controller
{
    public function index()
    {
        return view('customer.assets.debt_and_liabilities');
    }
}
