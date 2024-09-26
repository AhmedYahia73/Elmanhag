<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\question;
use App\Models\QuestionIssues;

class StudentQuestionIssue extends Model
{
    use HasFactory;
    
    protected $table = 'student_question_issue';

    protected $fillable = [
        'question_id',
        'user_id',
        'question_issue_id',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issue(){
        return $this->belongsTo(QuestionIssues::class, 'question_issue_id');
    }

    public function question(){
        return $this->belongsTo(question::class, 'question_id');
    }
}
