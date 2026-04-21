<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeceasedCaseNotification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'merge_payload' => 'array',
            'sent_at' => 'datetime',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(DeceasedCaseOrganization::class, 'deceased_case_organization_id');
    }

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class, 'notification_template_id');
    }
}
