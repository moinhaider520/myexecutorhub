<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LifeRememberedController extends Controller
{
    public function index()
    {
        return view('customer.life_remembered.life_remembered');
    }
}
