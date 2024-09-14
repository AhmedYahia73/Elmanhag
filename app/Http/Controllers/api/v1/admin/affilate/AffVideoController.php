<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\Http\Requests\api\admin\affilate\AffilateVideoRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

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
        // https://bdev.elmanhag.shop/admin/affilate/videos
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
        // https://bdev.elmanhag.shop/admin/affilate/videos/add
        // Keys
        // title, affilate_group_video_id, video
        $data = $request->only($this->affilateVideoRequest);
        $video =  $this->upload($request,'video','admin/affilate/affilate_videos'); // Upload Video
        $data['video'] = $video;
        $this->videos
        ->create($data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        // https://bdev.elmanhag.shop/admin/affilate/videos/update/{id}
        // Keys
        // title, affilate_group_video_id, video
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'affilate_group_video_id' => 'required|exists:affilate_group_videos,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $data = $request->only($this->affilateVideoRequest);
        $affilate_video = $this->videos
        ->where('id', $id)
        ->first();
        $video_path =  $this->upload($request,'video','admin/affilate/affilate_videos'); // Upload Video

        if (!empty($video_path) && $video_path != null) {
            $this->deleteImage($affilate_video->video); // Delete old video 
            $data['video'] = $video_path;
        }
        $affilate_video->update($data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/affilate/videos/delete/{id}
        
        $affilate_video = $this->videos
        ->where('id', $id)
        ->first();
        $this->deleteImage($affilate_video->video); // Delete old video
        $affilate_video->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
