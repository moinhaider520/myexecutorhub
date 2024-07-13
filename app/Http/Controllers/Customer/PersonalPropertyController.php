<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonalPropertyController extends Controller
{
    public function index()
    {
        return view('customer.assets.personal_property');
    }
}
