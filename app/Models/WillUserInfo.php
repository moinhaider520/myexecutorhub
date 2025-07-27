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
        return $this->belongsToMany(User::class, 'will_user_executors', 'will_user_info_id', 'executor_id')
            ->whereHas('roles', function ($q) {
                $q->where('name', 'executor');
            });
    }
}
