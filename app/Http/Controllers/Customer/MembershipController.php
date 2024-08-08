<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        return view('customer.membership.membership');
    }
    public function checkout_page()
    {
        return view('customer.membership.checkout');
    }
}
