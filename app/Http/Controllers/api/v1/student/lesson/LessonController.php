<?php

namespace App\Http\Controllers\api\v1\student\lesson;

use App\Http\Controllers\Controller;
use App\Models\bundle;
use App\Models\chapter;
use App\Models\lesson;
use App\Models\subject;
use ErrorException;
use GuzzleHttp\Psr7\Query;
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
              ->with('resources')
              ->with('homework')
              ->first(); // Start Get Leeon

              
             $chapter_id = $lesson->chapter_id; // Start Get The chapter about Lesson
             $purchaseStatus = $lesson->paid; // Start Get Purchase Status Lesson
            // $user_bundle = $user->where('id',$user_id)->with('bundles')->get(); // Test
            $drip_content = $lesson->drip_content;
            $lesson_order = $lesson->order;

              
            
        } catch (ErrorException $e) {

            return response()->json([
                'faield' => 'Not Found Lesson',
            ],404);
        }

    if ($purchaseStatus == true) {
   try {
                //  $user_subject =$user->subjects->where('category_id',$category_id)->where('education_id',$education_id);
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
                        // $lessons->materials ; // With Materials
                      $lessons->resources ; // With Resource
                      $lessons->homework ; // With Homework
                        if($drip_content == true){
                                try {
                             $beforLesson = $lessons
                            ->orderBy('order','DESC')
                            ->with('user_homework')
                            ->where('chapter_id',$chapter_id)
                            ->where('order','<',$lesson_order)
                            ->firstOrFail();
                         $user_homework = $beforLesson->user_homework;
                           if(count($user_homework) === 0) {
                                return response()->json([
                                    'faield'=>'The previous lesson was not solved.',
                                ]);
                           }
                                } catch (QueryException $th) {
                            return response()->json([
                                'faield'=>'You Can\'t Take This Lesson cuse Don\'t end homework Befor Lesson ', 
                            ]);
                                }
                 
                }
                }
                      return response()->json([
                      'data'=>'Lesson Return Successfully',
                      'lesson'=>$lessons,
                      ]);
            } catch (ErrorException $e) {
                return response()->json([
                    'faield'=>'This Lesson Is UnAvilable',
                    'error'=>$e->getMessage(),
                ],404);
            }
        } else {
               return response()->json([
                'data'=>'Lesson Return Successfully',
                'lesson'=>$lesson,
                ],200);
          
        }
    }
}
