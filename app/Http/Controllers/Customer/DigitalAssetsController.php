<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DigitalAssetsController extends Controller
{
    public function index()
    {
        return view('customer.assets.digital_assets');
    }
}
