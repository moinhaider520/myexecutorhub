<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{
    public function index()
    {
        $partners = User::role('partner')->get();
        return view('admin.partners.index', compact('partners'));
    }
}
