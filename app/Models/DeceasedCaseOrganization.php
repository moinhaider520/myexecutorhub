<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeceasedCaseOrganization extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'last_sent_at' => 'datetime',
        ];
    }

    public function deceasedCase()
    {
        return $this->belongsTo(DeceasedCase::class);
    }

    public function notifications()
    {
        return $this->hasMany(DeceasedCaseNotification::class)->latest();
    }

    public function replies()
    {
        return $this->hasMany(DeceasedCaseReply::class)->latest();
    }
}
