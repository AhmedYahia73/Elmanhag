<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonResource extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'source',
        'file',
        'link',
        'lesson_id',
    ];

    public function getfileAttribute($file){
        return $this->file = url('storage/' . $file);
    }
}
