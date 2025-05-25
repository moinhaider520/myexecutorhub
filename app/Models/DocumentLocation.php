<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLocation extends Model
{
    use HasFactory;

    protected $fillable = ['created_by', 'location'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
