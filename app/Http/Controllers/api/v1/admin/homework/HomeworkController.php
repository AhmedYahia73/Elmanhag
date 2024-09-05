<?php

namespace App\Http\Controllers\api\v1\admin\homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\lesson;
use App\Models\chapter;
use App\Models\subject;
use App\Models\homework;
use App\Models\category;
use App\Models\question;
use App\Models\QuestionGroup;

class HomeworkController extends Controller
{
    public function __construct(private chapter $chapters, private category $category,
    private lesson $lessons, private subject $subjects, private homework $homeworks,
    private question $question ){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/homework
        $chapters = $this->chapters->get();
        $lessons = $this->lessons->get();
        $subjects = $this->subjects->get();
        $categories = $this->category->get();
        $questions = $this->question->get();
        $homeworks = $this->homeworks
        ->with('subject')
        ->with('chapter')
        ->with('category')
        ->with('lesson')
        ->with('question_groups.questions')
        ->get();

        return response()->json([
            'chapters' => $chapters,
            'lessons' => $lessons,
            'subjects' => $subjects,
            'homeworks' => $homeworks,
            'categories' => $categories,
            'questions' => $questions
        ]);
    }
}
