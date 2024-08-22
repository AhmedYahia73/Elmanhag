<?php

namespace App\Http\Controllers\api\v1\student\lesson;

use App\Http\Controllers\Controller;
use App\Models\bundle;
use App\Models\chapter;
use App\Models\lesson;
use App\Models\subject;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    public function __construct(
        private lesson $lesson,
        private subject $subject,
        private bundle $bundle,
        private chapter $chapters,
    ) {}
    // This controller aboute All lessons 
    public function show_lesson(Request $request)
    { // Start Get Lesson For Student
         
        $user_id = $request->user()->id;
        $user = $request->user();
        $category_id = $request->user()->category_id;
        $education_id = $request->user()->education_id;
        $lesson_id = $request->lesson_id;
        $subject_id = $request->subject_id;
        $data_now = Carbon::now();
        try {
              $lesson = $this->lesson->where('id', $lesson_id)
              ->with('materials')
              ->with('resources')
              ->with('homework')
              ->first(); // Start Get Leeon
             $chapter_id = $lesson->chapter_id; // Start Get The chapter about Lesson
             $purchaseStatus = $lesson->paid; // Start Get Purchase Status Lesson
            // $user_bundle = $user->where('id',$user_id)->with('bundles')->get(); // Test
         
        } catch (ErrorException $e) {

            return response()->json([
                'faield' => 'Not Found Lesson',
                'data' => $e->getMessage(),
            ]);
        }

    if ($purchaseStatus == true) {
   try {
                 $user_bundle =$user->bundles->where('category_id',$category_id)->where('education_id',$education_id);
                     foreach ($user_bundle as $student_bundle) {
                    $dataNew = $student_bundle; // Get Bundle For Student
                    $subjects = $student_bundle->subjects // Get Subject
                    ->where('id', $subject_id)
                    ->where('expired_date', '>=', $data_now)->first(); // Get Subject
                    $chapter = $subjects->chapters;
                    $student_chapter = $chapter->where('id',$chapter_id)->first();// Get Chapter
                    $lessons = $student_chapter->lessons
                     ->where('id',$lesson_id)
                    ->first(); // Finaly Get Lesson for Studnet
                        $lessons->materials ; // With Materials
                      $lessons->resources ; // With Resource
                      $lessons->homework ; // With Homework
                }
                      return response()->json([
                      'data'=>'Lesson Return Successfully',
                      'lesson'=>$lessons,
                      ]);
            } catch (ErrorException $qe) {
                return response()->json([
                    'faield'=>'Some Error when Get Data',
                    'error'=>$qe->getMessage(),
                ]);
            }
        } else {
               return response()->json([
                'data'=>'Lesson Return Successfully',
                'lesson'=>$lesson,
                ]);
          
        }
    }
}
