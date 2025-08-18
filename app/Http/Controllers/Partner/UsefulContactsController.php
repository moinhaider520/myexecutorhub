<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsefulContactsController extends Controller
{
    public function index()
    {
        return view('partner.useful_contacts.index');
    }
}
