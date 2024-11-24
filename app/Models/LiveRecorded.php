<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\category;
use App\Models\chapter;
use App\Models\lesson;

class LiveRecorded extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'video',
        'category_id',
        'chapter_id',
        'lesson_id',
        'subject_id',
        'paid',
        'active',
        'semester',
        'price',
        'included',
    ];

    protected $appends = ['video_link'];

    public function getVideoLinkAttribute(){
        return url('storage/' . $this->attributes['video']);
    }

    public function category(){
        return $this->belongsTo(category::class, 'category_id');
    }

    public function user(){
        return $this->belongsToMany(User::class, 'user_live_recorded', 'recorded_id', 'user_id');
    }

    public function chapter(){
        return $this->belongsTo(chapter::class, 'chapter_id');
    }

    public function lesson(){
        return $this->belongsTo(lesson::class, 'lesson_id');
    }
}
