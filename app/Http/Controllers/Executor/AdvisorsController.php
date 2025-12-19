<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdvisorsController extends Controller
{
    public function view()
    {
        $roles = ['Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'];

        $contextUser = ContextHelper::user();
        $advisors = User::with('roles')
            ->where('created_by', $contextUser->id)
            ->whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })
            ->get();

        return view('executor.advisors.advisors', compact('advisors'));
    }
}
