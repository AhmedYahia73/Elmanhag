<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homework extends Model
{
    use HasFactory;

    protected $fillable = [
        'title' ,
        'semester' ,
        'category_id' ,
        'subject_id' ,
        'chapter_id' ,
        'lesson_id' ,
        'difficulty' ,
        'mark' ,
        'pass' ,
        'status' ,
    ];
}
