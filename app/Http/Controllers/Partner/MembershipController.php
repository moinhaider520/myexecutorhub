<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        return view('partner.membership.membership');
    }
    public function checkout_page()
    {
        return view('partner.membership.checkout');
    }
}
