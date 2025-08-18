<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsefulContactsController extends Controller
{
    public function index()
    {
        return view('customer.useful_contacts.index');
    }
}
