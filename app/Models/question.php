<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\category;
use App\Models\subject;
use App\Models\lesson;
use App\Models\chapter;

class question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question' ,
        'image' ,
        'audio' ,
        'status' ,
        'category_id' ,
        'subject_id' ,
        'lesson_id' ,
        'chapter_id' ,
        'semester' ,
        'answer_type' ,
        'difficulty' ,
        'question_type' ,
    ];

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function subject(){
        return $this->belongsTo(subject::class);
    }

    public function lesson(){
        return $this->belongsTo(lesson::class);
    }

    public function chapter(){
        return $this->belongsTo(chapter::class);
    }

    public function getimageAttribute($image){
        return $this->image = url('storage/' . $image);
    }

    public function getaudioAttribute($audio){
        return $this->audio = url('storage/' . $audio);
    }

}
