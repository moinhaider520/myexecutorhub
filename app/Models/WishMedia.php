<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishMedia extends Model
{
    protected $fillable = ['wish_id', 'file_path', 'file_type'];

    public function wish()
    {
        return $this->belongsTo(Wish::class);
    }

}
