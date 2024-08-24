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
    protected $appends = ['file_link'];

    public function getFileLinkAttribute($file){
        if($this->type == 'upload'){
            return url('storage/' . $this->attributes['file']);
        }
    }
}
