<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuidanceMedia extends Model
{
    protected $table = 'guidances_media';
    protected $fillable = ['life_remembered_id', 'file_path', 'file_type'];

    public function wish()
    {
        return $this->belongsTo(Guidance::class);
    }
}
