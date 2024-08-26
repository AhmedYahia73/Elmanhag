<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\subject;
use App\Models\category;
use App\Models\chapter;
use App\Models\lesson;

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


    public function subject(){
        return $this->belongsTo(subject::class);
    }

    public function chapter(){
        return $this->belongsTo(chapter::class);
    }

    public function category(){
        return $this->belongsTo(category::class);
    }
    public function question_groups(){
    return $this->hasMany(QuestionGroup::class);
    }

    public function lesson(){
        return $this->belongsTo(lesson::class);
    }
}
