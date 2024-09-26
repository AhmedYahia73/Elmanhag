<?php

namespace App\Http\Controllers\api\v1\admin\issues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StudentVideoIssue;

class VideoIssuesController extends Controller
{
    public function __construct(private StudentVideoIssue $issues){}

    public function show(){
        $issues = $this->issues
        ->with(['user', 'issue', 'video'])
        ->where('status', 1)
        ->get();

        return response()->json([
            'issues' => $issues
        ], 200);
    }

    public function seen($id){
        $this->issues
        ->where('id', $id)
        ->update([
            'status' => 0
        ]);

        return response()->json([
            'success' => 'You seen data success'
        ], 200);
    }
}
