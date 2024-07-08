<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function index()
    {
        return view('customer.assets.savings');
    }
}
