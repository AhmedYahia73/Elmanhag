<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\subject;
use App\Models\category;
use App\Models\Discount;
use App\Models\Education;

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
    protected $appends = ['thumbnail_link', 'cover_photo_link', 'demo_video_link'];

    public function getThumbnailLinkAttribute(){
        return url('storage/' . $this->attributes['thumbnail']);
    }

    public function getCoverPhotoLinkAttribute(){
        return url('storage/' . $this->attributes['cover_photo']);
    }

    public function getDemoVideoLinkAttribute(){
        return url('storage/' . $this->attributes['demo_video']);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'students_bundles');
    }

    public function subjects(){
        return $this->belongsToMany(subject::class, 'bundles_subjects');
    }

    public function education(){
        return $this->belongsTo(Education::class, 'education_id');
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
