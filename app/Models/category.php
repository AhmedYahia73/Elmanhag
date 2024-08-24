<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\subject;

class category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'thumbnail',
        'tags',
        'order' ,
        'category_id' ,
        'status' ,
    ];

    public function parent_category(){
        return $this->belongsTo(category::class, 'category_id');
    }

    public function subjects(){
        return $this->hasMany(subject::class, 'category_id');
    }
}
