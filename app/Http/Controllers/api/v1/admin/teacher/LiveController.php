<?php

namespace App\Http\Controllers\api\v1\admin\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Live;

class LiveController extends Controller
{
    public function __construct(private Live $live){}

    public function view(Request $request){
        $live = $this->live
        ->where('teacher_id', $request->teacher_id)
        ->with(['subject', 'category'])
        ->get();

        return response()->json([
            'lives' => $live
        ]);
    }
}
