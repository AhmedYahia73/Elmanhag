<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\lesson;
use App\Models\subject;

class chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'subject_id' ,
        'cover_photo' ,
        'thumbnail' ,
    ];

    public function subject(){
        return $this->belongsTo(subject::class);
    }

    public function lessons(){
        return $this->hasMany(lesson::class);
    }

}
