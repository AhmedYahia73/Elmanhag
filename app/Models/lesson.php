<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MaterialLesson;

class lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'description' ,
        'paid' ,
        'chapter_id' ,
        'status' ,
        'order' ,
        'drip_content' ,
    ];

    public function materials(){
        return $this->hasMany(MaterialLesson::class);
    }
    public function resources(){
        return $this->hasMany(LessonResource::class);
    }
    public function homework(){
        return $this->hasMany(LessonResource::class);
    }

}
