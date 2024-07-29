<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenAI extends Model
{
    protected $table = 'openai';
    protected $guarded=[];
    use HasFactory;
}
