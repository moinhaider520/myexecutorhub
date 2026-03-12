<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerSelfPurchaseCampaign extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'purchased_at' => 'datetime',
            'qualification_deadline' => 'datetime',
            'reward_granted_at' => 'datetime',
        ];
    }

    public function partnerUser()
    {
        return $this->belongsTo(User::class, 'partner_user_id');
    }

    public function customerUser()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }

    public function qualifyingReferrals()
    {
        return $this->hasMany(PartnerSelfPurchaseQualifyingReferral::class, 'campaign_id');
    }
}
