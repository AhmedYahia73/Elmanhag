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
        'education_id',
        'category_id',
        'subject_id',
        'price',
        'type',
        'month',
        'expire_date',
        'status',
    ];

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function subject(){
        return $this->belongsTo(subject::class);
    }

    public function videos(){
        return $this->hasMany(RevisionVideo::class);
    }

    public function user(){
        return $this->belongsToMany(User::class, 'user_revision', 'revision_id', 'user_id');
    }
}
