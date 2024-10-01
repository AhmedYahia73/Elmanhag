<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Discount;
use App\Models\category;
use App\Models\chapter;
use App\Models\bundle;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'price' ,
        'tags',
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
    protected $appends = ['demo_video_url','cover_photo_url','thumbnail_url'];

    public function bundles(){
        return $this->belongsToMany(bundle::class, 'bundles_subjects');
    }
    
    public function users(){
        return $this->belongsToMany(User::class, 'students_subjects');
    }

    
       
    public function getDemoVideoUrlAttribute(){
        return url('storage/' . $this->attributes['demo_video']) ?? url('storage/' . 'default.png');
    }
    
    public function getCoverPhotoUrlAttribute(){
        return url('storage/' . $this->attributes['cover_photo']) ?? url('storage/' . 'default.png');
    }

    public function getThumbnailUrlAttribute(){
        return url('storage/'.$this->attributes['thumbnail']) ?? url('storage/'.'default.png');
    }

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function chapters(){
        return $this->hasMany(chapter::class);
    }

    public function discount(){
        return $this->belongsToMany(Discount::class, 'discount_services')
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->where('statue', 1)
        ->orderByDesc('id');
    }
    // Feat =>  Live Session Relational
      public function live(){
      return $this->hasMany(live::class);
      }
}
