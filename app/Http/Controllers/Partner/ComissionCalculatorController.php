<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Support\PartnerActivationJourney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComissionCalculatorController extends Controller
{
    public function index()
    {
        $partner = Auth::user();

        if ($partner && $partner->hasRole('partner')) {
            if (!PartnerActivationJourney::canAccess($partner, PartnerActivationJourney::STEP_HOW_YOU_EARN)) {
                return redirect()->route(PartnerActivationJourney::nextRouteName($partner))
                    ->with('error', 'Please complete the activation steps in order.');
            }

            PartnerActivationJourney::markVisited($partner, PartnerActivationJourney::STEP_HOW_YOU_EARN);
        }

        return view('partner.commission_calculator.index');
    }
}
