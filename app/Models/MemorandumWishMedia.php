<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemorandumWishMedia extends Model
{
    use HasFactory;
    
    protected $fillable = ['memorandum_wish_id', 'file_path', 'file_type'];

    public function memorandumWish()
    {
        return $this->belongsTo(MemorandumWish::class);
    }
}
