<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\subject;
use App\Models\User;
use App\Models\category;
use App\Models\Education;

class Live extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'from',
        'to',
        'date',
        'day',
        'teacher_id',
        'subject_id',
        'category_id',
        'education_id',
        'paid',
        'price',
        'inculded',
    ];

    public function subject(){
        return $this->belongsTo(subject::class,'subject_id');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function education(){
        return $this->belongsTo(Education::class);
    }

    public function students(){
        return $this->belongsToMany(User::class, 'user_live');
    }
}
