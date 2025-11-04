<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function onboardingProgress()
    {
        return $this->hasOne(OnboardingProgress::class, 'user_id');
    }

    public function referredUsers()
    {
        return $this->hasMany(CouponUsage::class, 'partner_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'reffered_by');
    }

    public function usedCouponFrom()
    {
        return $this->hasOne(CouponUsage::class, 'user_id');
    }

    public function parentPartnerRelation()
    {
        return $this->hasOne(PartnerRelationship::class, 'sub_partner_id');
    }

    // Relationship to get the actual parent partner user
    public function parentPartner()
    {
        return $this->hasOneThrough(
            User::class,
            PartnerRelationship::class,
            'sub_partner_id', // Foreign key on PartnerRelationship
            'id', // Foreign key on User
            'id', // Local key on current User
            'parent_partner_id' // Local key on PartnerRelationship
        );
    }

    // Relationship to get all sub-partners under this partner
    public function subPartners()
    {
        return $this->hasManyThrough(
            User::class,
            PartnerRelationship::class,
            'parent_partner_id', // Foreign key on PartnerRelationship
            'id', // Foreign key on User
            'id', // Local key on current User
            'sub_partner_id' // Local key on PartnerRelationship
        );
    }



}
