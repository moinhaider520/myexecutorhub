<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    // Adjust fillable/guarded as per your application's needs
    protected $guarded = [];

    /**
     * Get the parent beneficiable model (family friend or charity).
     */
    public function beneficiable()
    {
        return $this->morphTo();
    }


    public function willUser()
    {
        return $this->belongsTo(WillUserInfo::class, 'will_user_id');
    }

    // Optional: Access the related model's name directly (for display purposes, e.g., in a summary)
    public function getNameAttribute()
    {
        if ($this->beneficiable) {
            if ($this->beneficiable_type === WillInheritedPeople::class) {
                return $this->beneficiable->first_name . ' ' . $this->beneficiable->last_name;
            } elseif ($this->beneficiable_type === Charity::class) {
                return $this->beneficiable->name;
            }
        }
        return 'Unknown Beneficiary';
    }
}
