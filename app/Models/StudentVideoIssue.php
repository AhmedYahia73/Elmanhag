<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\LessonResource;
use App\Models\VideoIssues;

class StudentVideoIssue extends Model
{
    use HasFactory;

    protected $table = 'student_video_issue';

    protected $fillable = [
        'lesson_resource_id',
        'user_id',
        'video_issue_id',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issue(){
        return $this->belongsTo(VideoIssues::class, 'video_issue_id');
    }

    public function video(){
        return $this->belongsTo(LessonResource::class, 'lesson_resource_id');
    }
}
