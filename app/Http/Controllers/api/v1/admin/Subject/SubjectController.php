<?php

namespace App\Http\Controllers\api\v1\admin\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;

class SubjectController extends Controller
{
    public function show(){
        // Get data
        $subjects = Subject::with([
            'discount',
            'category',
            'chapters.lessons.materials'
        ])
        ->withCount([
            'users as students',
            'chapters'
        ])
        ->get();

        // Manually add the count of lessons to each chapter
        foreach ($subjects as $subject) {
            $lessons = 0;
            foreach ($subject->chapters as $chapter) {
                $lessons += $chapter->lessons()->count();
            }
            $subject->lesson_count = $lessons;
        }

        return response()->json([
            'subjects' => $subjects
        ]);

    }
}
