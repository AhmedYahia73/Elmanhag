<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AffilateVideos;

class AffVideoController extends Controller
{
    public function __construct(private AffilateVideos $videos){}

    public function show(){
        $videos = $this->videos
        ->get();

        return response()->json([
            'videos' => $videos
        ]);
    }
}
