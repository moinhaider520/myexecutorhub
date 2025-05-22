<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeRememberedVideoMedia extends Model
{
     protected $fillable = ['life_remembered_video_id', 'file_path', 'file_type'];

    public function lifeRememberedVideo()
    {
        return $this->belongsTo(LifeRememberedVideo::class);
    }
}
