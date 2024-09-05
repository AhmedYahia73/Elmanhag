<?php

namespace App\Http\Controllers\api\v1\admin\question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\question;

class QuestionController extends Controller
{
    public function show(){
        // https://bdev.elmanhag.shop/admin/question
        $questions = question::
        with('category')
        ->with('subject')
        ->with('lesson')
        ->with('chapter')
        ->get();
        $question_types = ['text', 'image', 'audio'];

        return response()->json([
            'questions' => $questions,
            'question_types' => $question_types,
        ]);
    }
}
