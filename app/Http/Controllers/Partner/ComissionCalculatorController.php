<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComissionCalculatorController extends Controller
{
    public function index()
    {
        return view('partner.commission_calculator.index');
    }
}
