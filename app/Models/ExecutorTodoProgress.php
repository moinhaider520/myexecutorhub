<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutorTodoProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_item_id',
        'user_id',
        'created_by',
        'status',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function todoItem()
    {
        return $this->belongsTo(ExecutorTodoItem::class, 'todo_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeNotCompleted($query)
    {
        return $query->where('status', 'not_completed');
    }

    public function scopeNotRequired($query)
    {
        return $query->where('status', 'not_required');
    }
}