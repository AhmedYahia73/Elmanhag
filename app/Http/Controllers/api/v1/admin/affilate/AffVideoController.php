<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\Http\Requests\api\admin\affilate\AffilateVideoRequest;

use App\Models\AffilateGroupVideos;
use App\Models\AffilateVideos;

class AffVideoController extends Controller
{
    use image;
    public function __construct(private AffilateVideos $videos, 
    private AffilateGroupVideos $groups){}

    protected $affilateVideoRequest = [
        'title',
        'affilate_group_video_id',
    ];

    public function show(){
        $videos = $this->videos
        ->get();
        $groups = $this->groups
        ->get();

        return response()->json([
            'videos' => $videos,
            'groups' => $groups,
        ]);
    }

    public function add(AffilateVideoRequest $request){
        $data = $request->only($this->affilateVideoRequest);
        $video =  $this->upload($request,'video','admin/affilate/affilate_videos'); // Upload Video
        $data['video'] = $video;
        $this->videos
        ->create($data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
}
