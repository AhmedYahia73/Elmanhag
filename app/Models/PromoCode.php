<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title' ,
        'code' ,
        'value' ,
        'precentage' ,
        'usage_type' ,
        'usage' ,
        'number_users' ,
    ];
}
