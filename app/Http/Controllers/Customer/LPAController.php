<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LPAController extends Controller
{
    public function index()
    {      
        return view('customer.lpa.index');
    }

    public function create()
    {      
        return view('customer.lpa.create');
    }
}
