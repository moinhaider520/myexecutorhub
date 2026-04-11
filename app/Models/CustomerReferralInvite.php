<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReferralInvite extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'opened_at' => 'datetime',
            'activated_at' => 'datetime',
            'reward_pending_at' => 'datetime',
            'reward_confirmed_at' => 'datetime',
            'last_sent_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_user_id');
    }

    public function invitedUser()
    {
        return $this->belongsTo(User::class, 'invited_user_id');
    }

    public function referral()
    {
        return $this->hasOne(CustomerReferral::class, 'invite_id');
    }
}
