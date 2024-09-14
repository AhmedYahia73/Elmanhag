<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AffilateGroupVideos;

class AffilateVideos extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'video',
        'affilate_group_video_id',
    ];

    public function affilate_group_video(){
        return $this->belongsTo(AffilateGroupVideos::class, 'affilate_group_video_id');
    }
}
