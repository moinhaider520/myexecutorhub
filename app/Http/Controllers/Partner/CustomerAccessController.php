<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerSelfPurchaseCampaign;
use Illuminate\Support\Facades\Auth;

class CustomerAccessController extends Controller
{
    public function index()
    {
        $partner = Auth::user();
        $campaign = PartnerSelfPurchaseCampaign::where('partner_user_id', $partner->id)
            ->latest('purchased_at')
            ->first();

        return view('partner.customer_access.index', [
            'partner' => $partner,
            'campaign' => $campaign,
            'linkedCustomerAccount' => $partner->linkedPartnerCustomerAccount,
        ]);
    }
}
