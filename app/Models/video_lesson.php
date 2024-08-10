<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'lesson_id' ,
        'status' ,
    ];
}
