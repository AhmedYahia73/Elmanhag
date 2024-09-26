<?php

namespace App\Http\Controllers\api\v1\admin\issues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StudentQuestionIssue;

class QuestionIssuesController extends Controller
{
    public function __construct(private StudentQuestionIssue $issues){}

    public function show(){
        $issues = $this->issues
        ->with(['user', 'issue', 'question'])
        ->where('status', 1)
        ->get();

        return response()->json([
            'issues' => $issues
        ]);
    }

    public function seen($id){
        $this->issues
        ->where('id', $id)
        ->update([
            'status' => 0
        ]);

        return response()->json([
            'data' => 'You seen data success'
        ]);
    }
}
