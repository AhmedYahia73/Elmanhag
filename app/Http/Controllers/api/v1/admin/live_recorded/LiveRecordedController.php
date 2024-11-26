<?php

namespace App\Http\Controllers\api\v1\admin\live_recorded;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\LiveRecorded;

class LiveRecordedController extends Controller
{
    public function __construct(private LiveRecorded $live_recorded){}

    public function view(){
        // https://bdev.elmanhag.shop/admin/recordedLive
        $live_recorded = $this->live_recorded
        ->with(['category', 'chapter', 'lesson'])
        ->get();

        return response()->json([
            'live_recorded' => $live_recorded
        ]);
    }

    // public function included(Request $request, $id){                 
    //     $validator = Validator::make($request->all(), [
    //         'included' => 'required|boolean',
    //     ]);
    //     if ($validator->fails()) { // if Validate Make Error Return Message Error
    //         return response()->json([
    //             'error' => $validator->errors(),
    //         ],400);
    //     }
    //     $this->live_recorded
    //     ->where('id', $id)
    //     ->update([
    //         'included' => $request->included
    //     ]);

    //     return response()->json([
    //         'success' => $request->included ? 'active' : 'not active'
    //     ]);
    // }
    
    public function live_item($id){
        // https://bdev.elmanhag.shop/admin/recordedLive/live_item/{id}
        $live_recorded = $this->live_recorded
        ->where('id', $id)
        ->with(['category', 'chapter', 'lesson'])
        ->first();

        return response()->json([
            'live_recorded' => $live_recorded
        ]);
    }
}
