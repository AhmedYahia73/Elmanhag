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
            $order = $lesson->order;
            $lesson_order = $lesson->order;
            $lesson_status = $lesson->status;
            $lesson_switch = $lesson->switch;
            if($lesson_status == false){
                return response()->json([
                    'faield'=>'This Lesson Is Closed',
                ],204);
            }
            //  Geck Previos 
            if ($drip_content == true && $order   > 1) {
                try {
                    $beforLesson = $lesson
                        ->orderBy('order', 'DESC')
                        ->with('user_homework')->where('chapter_id', $chapter_id)
                        ->where('order', '<', $lesson_order)
                        ->orwhere('order', '=', '1')
                        ->first();
                        if(empty($beforLesson)){
                                return response()->json([
                                'not_found' => 'Not Found homeWork for previous lesson.',
                            ], 404);
                        }
                    $user_homework = $beforLesson->user_homework;
                    if (count($user_homework) === 0) {
                        return response()->json([
                            'lesson_not_solved' => 'The previous lesson was not solved.',
                        ], 500);
                    }
                } catch (QueryException $th) {
                    return response()->json([
                        'faield' => 'You Can\'t Take This Lesson cuse Don\'t end homework Befor Lesson',
                    ], 403);
                }
            }
            //  Geck Previos 
        } catch (ErrorException $e) {

            return response()->json([
                'faield' => 'This Lesson Not Found',
            ], 404);
        }
        if ($purchaseStatus == true) {
             //  $user_subject =$user->subjects->where('category_id',$category_id)->where('education_id',$education_id);
           $user_bundle = $user->bundles->where('category_id', $category_id)->where('education_id', $education_id);
          if (count($user_bundle) === 0) {
                $user_subject = $user->subjects->where('category_id', $category_id)->where('id', $subject_id)->where('education_id', $education_id)->first();
                if( empty($user_subject) ){
                        return response()->json([
                        'faield'=>'This Lesson Unpaid',
                        ],400);
                }
                $chapter =   $user_subject->chapters->where('id', $chapter_id)->first();
                $lessons = $chapter->lessons->where('id', $lesson_id)->first();
                $lessons->resources; // With Resource
                $lessons->homework; // With Homework
            } else {
                foreach ($user_bundle as $student_bundle) {
                    $dataNew = $student_bundle; // Get Bundle For Student
                    $subjects = $student_bundle->subjects // Get Subject
                        ->where('id', $subject_id)
                        ->where('expired_date', '>=', $data_now)->first(); // Get Subject
                        try {
                            $chapter = $subjects->chapters;
                        } catch (ErrorException $queryException) {
                            return response()->json([
                                'not_found'=>'This Bundle Don\'t Have Subject',
                                'error'=>$queryException->getMessage(),
                            ],400);
                        }
                    $student_chapter = $chapter->where('id', $chapter_id)->first(); // Get Chapter
                    $lessons = $student_chapter->lessons
                        ->where('id', $lesson_id)
                        ->first(); // Finaly Get Lesson for Studnet

                    // $lessons->materials ; // With Materials
                    if($lesson_switch == true){

                        $lessons->resources; // With Resource
                        $lessons->homework; // With Homework
                    }else{
                        return response()->json([
                            'faield'=>'This Material for This Lesson is Closed',
                        ]);
                    }

                }
            }
            return response()->json([
                'data' => 'Lesson Return Successfully',
                'lesson' => $lessons,
            ]);
        } else {
            return response()->json([
                'data' => 'Lesson Return Successfully',
                'lesson' => $lesson,
            ], 200);
        }
    }
}
