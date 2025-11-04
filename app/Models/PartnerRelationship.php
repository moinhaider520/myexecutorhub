<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerRelationship extends Model
{
    protected $fillable = ['parent_partner_id', 'sub_partner_id'];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_partner_id');
    }

    public function subPartner()
    {
        return $this->belongsTo(User::class, 'sub_partner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sub_partner_id');
    }

    public function parentPartner()
    {
        return $this->belongsTo(User::class, 'parent_partner_id');
    }
}
