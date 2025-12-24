<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    protected $guarded=[];
protected $casts = [
    'file_path' => 'array',
];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
