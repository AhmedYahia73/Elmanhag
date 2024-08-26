<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\lesson;
use App\Models\subject;

class chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'subject_id' ,
        'cover_photo' ,
        'thumbnail' ,
    ];
    protected $appends = ['cover_photo','thumbnail'];
    
    public function getCoverPhotoAttribute(){
        return url('storage/' . $this->attributes['cover_photo']) ;
    }
    
    public function getThumbnailAttribute(){
        return url('storage/' . $this->attributes['thumbnail']) ;
    }
    
    public function subject(){
        return $this->belongsTo(subject::class);
    }

    public function lessons(){
        return $this->hasMany(lesson::class);
    }

}
