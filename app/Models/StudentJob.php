<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentJob extends Model
{
    use HasFactory;
    protected $fillable = [
        'job' ,
        'title_male' ,
        'title_female' ,
    ];
}
