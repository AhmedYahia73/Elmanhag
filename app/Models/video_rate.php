<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate' ,
        'video_lesson_id' ,
        'user_id' ,
    ];
}
