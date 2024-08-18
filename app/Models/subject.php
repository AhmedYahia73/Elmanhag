<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Discount;
use App\Models\category;
use App\Models\chapter;

class subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'price' ,
        'category_id' ,
        'demo_video',
        'cover_photo',
        'thumbnail',
        'education_id',
        'url',
        'description',
        'status',
        'semester',
        'expired_date' ,
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'students_subjects');
    }
         public function getcoverPhotoAttribute($data){

         return $this->demo_video = [
         'path'=>$data,
         'url'=> url('storage/'.$data) ?? url('storage/'.'default.png'),
         ];

         }
         public function getdemoVideoAttribute($data){

         return $this->demo_video = [
         'path'=>$data,
         'url'=> url('storage/'.$data) ?? url('storage/'.'default.png'),
         ];

         }
         public function getAllAttributes()
{
    $columns = $this->getFillable();
    // Another option is to get all columns for the table like so:
    // $columns = \Schema::getColumnListing($this->table);
    // but it's safer to just get the fillable fields
    $attributes = $this->getAttributes();

    foreach ($columns as $column)
    {
        if (!array_key_exists($column, $attributes))
        {
            $attributes[$column] = null;
        }
    }
    return $attributes;
}
         public function getthumbnailAttribute($data){

         return $this->demo_video = [
         'path'=>$data,
         'url'=> url('storage/'.$data) ?? url('storage/'.'default.png'),
         ];

         }
    public function category(){
        return $this->belongsTo(category::class);
    }

    public function chapters(){
        return $this->hasMany(chapter::class);
    }

    public function discount(){
        return $this->hasMany(Discount::class)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->where('statue', 1)
        ->orderByDesc('id');
    }
}
