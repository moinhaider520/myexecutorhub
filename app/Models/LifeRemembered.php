<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeRemembered extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->hasMany(LifeRememberedMedia::class);
    }
}
