<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     /**
     * Display the customer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('executor.dashboard');
    }
}
