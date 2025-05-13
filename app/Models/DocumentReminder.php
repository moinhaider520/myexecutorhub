<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type',
        'frequency',
        'last_reminded_at',
    ];

    protected $casts = [
        'last_reminded_at' => 'date',
    ];

    /**
     * Get the user that owns the reminder.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}