<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\VideoIssues;

class LessonResource extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'source',
        'file',
        'lesson_id',
    ];
    protected $appends = ['file_link'];

    public function getFileLinkAttribute($file){
        if($this->source == 'upload'){
            return url('storage/' . $this->attributes['file']);
        }
    }

    public function videoIssues(){
        return $this->belongsToMany(VideoIssues::class, 'student_video_issue', 'lesson_resource_id', 'video_issue_id');
    }
}
