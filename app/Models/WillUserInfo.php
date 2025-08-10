<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WillUserInfo extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function executors()
    {
        return $this->belongsToMany(User::class, 'will_user_executors', 'will_user_info_id', 'executor_id');
    }

   public function child()
    {
        return $this->hasMany(WillInheritedPeople::class, 'will_user_id', 'id')
                    ->where('type', 'child');
    }
   public function pet()
    {
        return $this->hasMany(WillInheritedPeople::class, 'will_user_id', 'id')
                    ->where('type', 'pet');
    }
    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class, 'will_user_id', 'id');
    }

    public function account_properties()
    {
        return $this->hasMany(WillUserAccountsProperty::class, 'will_user_id', 'id');
    }


}
