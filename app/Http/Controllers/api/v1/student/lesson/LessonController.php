<?php

namespace App\Http\Controllers\api\v1\student\lesson;

use App\Http\Controllers\Controller;
use App\Models\bundle;
use App\Models\lesson;
use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    public function __construct(
        private lesson $lesson,
        private subject $subject,
        private bundle $bundle,
    ) {}
    // This controller aboute All lessons 
    public function show_lesson(Request $request)
    { // Start Get Lesson For Student
         
        $lesson_id = $request->lesson_id;
        $subject_id = $request->subject_id;
        $user = $request->user();
        $user_id = $request->user()->id;
        $category_id = $request->user()->category_id;
        $lesson = $this->lesson->where('id', $lesson_id)->first();
        $purchaseStatus = $lesson->paid;
        if ($purchaseStatus == true) {
            $status = 'This Student Don\'t Buy This Lesson';
            $bundleSubject = $user
                ->where('id', $user_id)
                ->with('bundles.subjects.chapters.lessons')
                ->whereHas('bundles.subjects.chapters.lessons', function ($query) use ($lesson_id) {
                    $query->where('lessons.id', $lesson_id);
                })->first();
            $bundles = $bundleSubject->bundles;
            $lessons = $bundles[0]->subjects[0]->chapters[0]->lessons;
            $lesson =  $lessons->where('id',$lesson_id)->first();
            return response()->json([
                'response' => $lesson,
            ]);
        } else {
            $status = 'This Student Has This Lesson';

            return response()->json([
                'success' => 'data return successfully',
                'data' => $lesson,
            ]);
        }
    }
}
