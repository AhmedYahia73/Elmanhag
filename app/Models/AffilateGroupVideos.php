<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AffilateVideos;

class AffilateGroupVideos extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];

    public function affilate_videos(){
        return $this->hasMany(AffilateVideos::class, 'affilate_group_video_id');
    }
}
