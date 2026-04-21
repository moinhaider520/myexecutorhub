<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeceasedCase extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'deceased_date_of_birth' => 'date',
            'deceased_date_of_death' => 'date',
            'grant_issue_date' => 'date',
            'letters_of_administration_issue_date' => 'date',
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
            'snapshot' => 'array',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function verification()
    {
        return $this->belongsTo(DeathCertificateVerification::class, 'death_certificate_verification_id');
    }

    public function organizations()
    {
        return $this->hasMany(DeceasedCaseOrganization::class)->orderBy('organisation_type')->orderBy('organisation_name');
    }
}
