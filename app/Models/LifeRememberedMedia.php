<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeRememberedMedia extends Model
{
    protected $fillable = ['life_remembered_id', 'file_path', 'file_type'];

    public function wish()
    {
        return $this->belongsTo(LifeRemembered::class);
    }
}
