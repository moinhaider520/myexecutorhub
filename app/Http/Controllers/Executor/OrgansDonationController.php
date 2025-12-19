<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrgansDonation;
use Illuminate\Support\Facades\Auth;

class OrgansDonationController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $organ_donations = OrgansDonation::where('created_by', $contextUser->id)->get();

        return view('executor.donations.organs_donation', compact('organ_donations'));
    }
}
