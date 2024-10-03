<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\question;

class RevisionQuestionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'revision_id',
    ];

    public function questions(){
        return $this->belongsToMany(question::class, 'revision_question_group_question', 'revision_question_g_id', 'question_id');
    }
}
