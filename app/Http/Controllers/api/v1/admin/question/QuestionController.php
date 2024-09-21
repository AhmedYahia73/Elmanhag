<?php

namespace App\Http\Controllers\api\v1\admin\question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\question;
use App\Models\category;
use App\Models\subject;
use App\Models\chapter;

class QuestionController extends Controller
{

    public function __construct(private question $question,
    private lesson $lesson, private chapter $chapter){}
    public function show(){
        // https://bdev.elmanhag.shop/admin/question
        $questions = $this->question
        ->with('category')
        ->with('subject')
        ->with('lesson')
        ->with('chapter')
        ->get();
        $lesson = $this->lesson->get();
        $chapter = $this->chapter->get();
        $question_types = ['text', 'image', 'audio'];

        return response()->json([
            'questions' => $questions,
            'question_types' => $question_types,
            'lesson' => $lesson,
            'chapter' => $chapter,
        ]);
    }
}
