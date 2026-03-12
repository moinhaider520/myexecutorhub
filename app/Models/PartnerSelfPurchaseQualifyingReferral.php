<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerSelfPurchaseQualifyingReferral extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'qualified_at' => 'datetime',
        ];
    }

    public function campaign()
    {
        return $this->belongsTo(PartnerSelfPurchaseCampaign::class, 'campaign_id');
    }

    public function partnerUser()
    {
        return $this->belongsTo(User::class, 'partner_user_id');
    }

    public function referredCustomer()
    {
        return $this->belongsTo(User::class, 'referred_customer_user_id');
    }
}
