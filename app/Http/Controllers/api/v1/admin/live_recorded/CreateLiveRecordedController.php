<?php

namespace App\Http\Controllers\api\v1\admin\live_recorded;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\live_recorded\LiveRecordedRequest;
use App\trait\image;

use App\Models\LiveRecorded;

class CreateLiveRecordedController extends Controller
{
    public function __construct(private LiveRecorded $live_recorded){}
    use image;
    protected $liveRequest = [
        'name',
        'description',
        'category_id',
        'chapter_id',
        'lesson_id',
        'subject_id',
        'paid',
        'active',
        'semester',
        'price',
        'included',
    ];

    public function add(LiveRecordedRequest $request){
        // https://bdev.elmanhag.shop/admin/recordedLive/add
        // Keys
        // name, description, category_id, chapter_id, lesson_id, subject_id
        // paid, active, video, semester, price, included
        $data = $request->only($this->liveRequest);
        if (is_file($request->video)) {
            $video =  $this->upload($request,'video','admin/live_recorded/video'); // Upload video
            $data['video'] = $video;
        }
        $live_recorded = $this->live_recorded
        ->create($data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(LiveRecordedRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/recordedLive/update/{id}
        // Keys
        // name, description, category_id, chapter_id, lesson_id, subject_id
        // paid, active, video, semester, price, included
        $data = $request->only($this->liveRequest);
        $live_recorded = $this->live_recorded
        ->where('id', $id)
        ->first();
        if (is_file($request->video)) {
            $video =  $this->upload($request,'video','admin/live_recorded/video'); // Upload video
            $data['video'] = $video;
            $this->deleteImage($live_recorded->video);
        }
        $live_recorded->update($data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/recordedLive/delete/{id}
        $live_recorded = $this->live_recorded
        ->where('id', $id)
        ->first();
        $this->deleteImage($live_recorded->video);
        $live_recorded->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }

}
