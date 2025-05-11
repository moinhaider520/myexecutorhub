<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;
    protected $fillable = ['partner_id', 'user_id'];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
