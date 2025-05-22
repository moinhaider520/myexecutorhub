<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeRememberedVideo extends Model
{
    protected $fillable = ['description', 'created_by'];

    public function media()
    {
        return $this->hasMany(LifeRememberedVideoMedia::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
