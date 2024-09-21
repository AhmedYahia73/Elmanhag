<?php

namespace App\Http\Controllers\api\v1\admin\live;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\live\LiveRequest;

use App\Models\Live;

class CreateLiveController extends Controller
{
    public function __construct(private Live $live){}
    protected $liveRequest = [
        'name',
        'from',
        'to',
        'date',
        'day',
        'teacher_id',
        'subject_id',
        'paid',
        'category_id',
        'education_id',
        'price',
        'inculded',
    ];

    public function create(LiveRequest $request){
        // https://bdev.elmanhag.shop/admin/live/add
        // Keys
        // name, from, to, date, category_id, education_id, day, teacher_id, subject_id, paid, price, inculded
        $liveData = $request->only($this->liveRequest);
        $this->live->create($liveData);

        return response()->json([
            'success' => 'You add live success'
        ]);
    }
    
    public function modify(LiveRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/live/update/{$id}
        // Keys
        // name, from, to, date, category_id, education_id, day, teacher_id, subject_id, paid, price, inculded
        $liveData = $request->only($this->liveRequest);
        $live = $this->live->where('id', $id)
        ->first();
        $live->update($liveData);

        return response()->json([
            'success' => 'You update live success'
        ]);
    }
    
    public function delete($id){
        // https://bdev.elmanhag.shop/admin/live/delete/{$id}
        $live = $this->live->where('id', $id)
        ->first();
        $live->delete();

        return response()->json([
            'success' => 'You delete live success'
        ]);
    }
}
