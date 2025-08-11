<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WillInheritedPeople extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function beneficiaries()
    {
        return $this->morphMany(Beneficiary::class, 'beneficiable');
    }


    public function willUserInfosAsExecutor()
    {
        return $this->belongsToMany(WillUserInfo::class, 'will_user_executors', 'executor_id', 'will_user_info_id');
    }

}
