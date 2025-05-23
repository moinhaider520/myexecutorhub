<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutorTodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id',
        'title',
        'description',
        'order',
    ];

    public function stage()
    {
        return $this->belongsTo(ExecutorTodoStage::class, 'stage_id');
    }

    public function progress()
    {
        return $this->hasMany(ExecutorTodoProgress::class, 'todo_item_id');
    }

    public function userProgress($userId, $createdBy)
    {
        return $this->hasOne(ExecutorTodoProgress::class, 'todo_item_id')
            ->where('user_id', $userId)
            ->where('created_by', $createdBy);
    }
}