<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerCustomerAccount extends Model
{
    protected $guarded = [];

    public function partnerUser()
    {
        return $this->belongsTo(User::class, 'partner_user_id');
    }

    public function customerUser()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }
}
