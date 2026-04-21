<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeceasedCaseReply extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'received_at' => 'date',
            'payload' => 'array',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(DeceasedCaseOrganization::class, 'deceased_case_organization_id');
    }

    public function notification()
    {
        return $this->belongsTo(DeceasedCaseNotification::class, 'deceased_case_notification_id');
    }
}
