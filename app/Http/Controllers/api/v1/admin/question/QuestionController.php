<?php

namespace App\Http\Controllers\api\v1\admin\question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\question;

class QuestionController extends Controller
{
    public function show(){
        $questions = question::
        with('category')
        ->with('subject')
        ->with('lesson')
        ->with('chapter')
        ->get();

        return response()->json([
            'questions' => $questions,
        ]);
    }
}
