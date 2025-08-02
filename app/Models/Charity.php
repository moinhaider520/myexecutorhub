<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    protected $guarded=[];
    use HasFactory;


    public function beneficiaries()
    {
        return $this->morphMany(Beneficiary::class, 'beneficiable');
    }
}
