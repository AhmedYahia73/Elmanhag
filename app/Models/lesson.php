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
        'chapter_id' ,
        'status' ,
        'order' ,
        'loged' ,
    ];

    public function materials(){
        return $this->hasMany(MaterialLesson::class);
    }

}
