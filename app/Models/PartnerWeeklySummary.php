<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerWeeklySummary extends Model
{
    protected $guarded = [];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
