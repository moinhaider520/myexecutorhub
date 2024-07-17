<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgansDonation extends Model
{
    protected $table = 'organs_donation';
    protected $guarded=[];
    use HasFactory;
}
