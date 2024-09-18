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
        'switch',
        'order' ,
        'drip_content' ,
    ];

  
    public function resources(){
        return $this->hasMany(LessonResource::class);
    }
    public function homework(){
        return $this->hasMany(homework::class);
    }
    public function user_homework(){
        return $this->belongsToMany(homework::class,'users_homework');
    }

}
