<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdvisorsController extends Controller
{
    public function view()
    {
        $roles = ['Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'];

        $user = Auth::user();
        $advisors = User::with('roles')
            ->where('created_by', $user->created_by)
            ->whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })
            ->get();
            
        return view('others.advisors.advisors', compact('advisors'));
    }
}
