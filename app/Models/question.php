<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question' ,
        'image' ,
        'audio' ,
        'statues' ,
        'category_id' ,
        'subject_id' ,
        'lesson_id' ,
        'semester' ,
        'answer_type' ,
        'difficulty' ,
        'question_type' ,
    ];
}
