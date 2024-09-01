<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffilateAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'income' ,
        'wallet' ,
        'affilate_id' ,
    ];
}
