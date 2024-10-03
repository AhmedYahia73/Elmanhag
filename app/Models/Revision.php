<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\subject;
use App\Models\category;
use App\Models\RevisionQuestionGroup;

class Revision extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'semester',
        'category_id',
        'subject_id',
        'mark',
        'type',
        'month',
        'status',
    ];

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function subject(){
        return $this->belongsTo(subject::class);
    }

    public function question_groups(){
        return $this->hasMany(RevisionQuestionGroup::class);
    }
}
