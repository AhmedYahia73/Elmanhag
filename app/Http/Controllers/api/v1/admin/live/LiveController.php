<?php

namespace App\Http\Controllers\api\v1\admin\live;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Live;

class LiveController extends Controller
{
    public function __construct(private Live $live){}
    public function show(){
        $live = $this->live
        ->with(['subject', 'teacher'])
        ->get();

        return response()->json([
            'live' => $live
        ]);
    }
}
