<?php

namespace App\Http\Controllers\api\v1\admin\live_recorded;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LiveRecorded;

class LiveRecordedController extends Controller
{
    public function __construct(private LiveRecorded $live_recorded){}

    public function view(){
        $live_recorded = $this->live_recorded
        ->with(['category', 'chapter', 'lesson'])
        ->get();

        return response()->json([
            'live_recorded' => $live_recorded
        ]);
    }
    
    public function live_item($id){
        $live_recorded = $this->live_recorded
        ->where('id', $id)
        ->with(['category', 'chapter', 'lesson'])
        ->first();

        return response()->json([
            'live_recorded' => $live_recorded
        ]);
    }
}
