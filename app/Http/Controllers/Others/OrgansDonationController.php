<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrgansDonation;
use Illuminate\Support\Facades\Auth;

class OrgansDonationController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve organ donations created by the authenticated user
        $organ_donations = OrgansDonation::where('created_by', $user->created_by)->get();
        
        return view('others.donations.organs_donation', compact('organ_donations'));
    }
}
