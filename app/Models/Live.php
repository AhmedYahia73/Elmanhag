<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\subject;
use App\Models\User;

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
        'paid',
        'price',
    ];

    public function subject(){
        return $this->belongsTo(subject::class,'subject_id');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }
}
