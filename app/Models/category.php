<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'thumbnail',
        'tags',
        'category_id' ,
        'status' ,
    ];

    public function parent_category(){
        return $this->belongsTo(category::class, 'category_id');
    }
}
