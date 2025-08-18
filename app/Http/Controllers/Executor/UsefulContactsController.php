<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsefulContactsController extends Controller
{
    public function index()
    {
        return view('executor.useful_contacts.index');
    }
}
