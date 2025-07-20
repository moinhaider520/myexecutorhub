<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WillGeneratorController extends Controller
{
    public function index()
    {
        // $wills = WillVideos::where('customer_id', Auth::id())->get();
        return view('partner.will_generator.index');
    }

    public function create()
    {
        $authId = auth()->id();
        return view('partner.will_generator.create', ['authId' => $authId]);
    }

    public function about_you()
    {
        $authId = auth()->id();
        return view('partner.will_generator.about_you', ['authId' => $authId]);
    }
}
