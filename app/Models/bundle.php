<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\subject;
use App\Models\category;
use App\Models\Discount;

class bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'          ,
        'price'         ,
        'tags'          ,
        'thumbnail'     ,
        'cover_photo'   ,
        'demo_video'    ,
        'url'           ,
        'description'   ,
        'category_id'   ,
        'education_id'  ,
        'expired_date'  ,
        'semester'      ,
        'status'        ,
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'students_bundles');
    }

    public function subjects(){
        return $this->belongsToMany(subject::class, 'bundles_subjects');
    }

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function discount(){
        return $this->belongsToMany(Discount::class, 'discount_services')
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->where('statue', 1)
        ->orderByDesc('id');
    }
}
