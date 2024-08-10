<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLesson extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'material',
        'lesson_id',
    ];
}
