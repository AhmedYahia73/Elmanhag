<?php

namespace App\Http\Controllers\api\v1\admin\homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\lesson;
use App\Models\chapter;
use App\Models\subject;
use App\Models\homework;

class HomeworkController extends Controller
{
    public function __construct(private chapter $chapters, 
    private lesson $lessons, private subject $subjects, private homework $homeworks ){}

    public function show(){
        $chapters = $this->chapters->get();
        $lessons = $this->lessons->get();
        $subjects = $this->subjects->get();
        $homeworks = $this->homeworks
        ->with('subject')
        ->with('chapter')
        ->with('category')
        ->with('lesson')
        ->get();

        return response()->json([
            'chapters' => $chapters,
            'lessons' => $lessons,
            'subjects' => $subjects,
            'homeworks' => $homeworks,
        ]);
    }
}
