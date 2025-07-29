<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WillUserFuneral extends Model
{
    use HasFactory;

    protected $guarded=[];

    // Define relationship to WillUserInfo
    public function willUserInfo()
    {
        return $this->belongsTo(WillUserInfo::class, 'will_user_id');
    }

    // Define relationship to User (for created_by)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
