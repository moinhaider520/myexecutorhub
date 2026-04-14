<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathCertificateVerification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'extracted_data' => 'array',
            'normalized_data' => 'array',
            'document_checks' => 'array',
            'match_checks' => 'array',
            'fraud_checks' => 'array',
            'mismatch_reasons' => 'array',
            'verified_at' => 'datetime',
        ];
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function duplicateOf()
    {
        return $this->belongsTo(self::class, 'duplicate_of_verification_id');
    }

    public function reviewActions()
    {
        return $this->hasMany(DeathCertificateReviewAction::class, 'verification_id');
    }
}
