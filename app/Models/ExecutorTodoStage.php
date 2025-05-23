<?php

// app/Models/ExecutorTodoStage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutorTodoStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order',
        'type',
    ];

    public function todoItems()
    {
        return $this->hasMany(ExecutorTodoItem::class, 'stage_id')->orderBy('order');
    }
}