<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\question;

class QuestionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'homework_id',
    ];

    public function questions(){
        return $this->belongsToMany(question::class, 'question_group_question');
    }
}
