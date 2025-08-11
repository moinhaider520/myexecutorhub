<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WillUserInheritedGift extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function getInheritedPeopleAttribute()
    {
        $ids = explode(',', $this->family_inherited_id);

        return WillInheritedPeople::whereIn('id', $ids)->get();
    }
}
