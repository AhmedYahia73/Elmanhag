<?php

namespace App\Http\Controllers\api\v1\student\lesson;

use App\Http\Controllers\Controller;
use App\Models\bundle;
use App\Models\lesson;
use App\Models\subject;
use ErrorException;
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
        try {
             $lesson = $this->lesson->where('id', $lesson_id)->first();
             $chapter_id = $lesson->chapter_id;
             $purchaseStatus = $lesson->paid;
        } catch (ErrorException $e) {

            return response()->json([
                'faield' => 'Not Found Lesson',
                'data' => $e->getMessage(),
            ]);
        }

    if ($purchaseStatus == true) {
            $status = 'This Student Don\'t Buy This Lesson';
             try {
                return $bundleSubject = $user
                    ->where('id', $user_id)
                    ->with('bundles.subjects.chapters', function ($query) use ( $chapter_id) {
                        return $query->where('id', $chapter_id)->with('lessons');
                    })->get();
                    foreach ($bundleSubject as $student_bundle) {
                     $student_bundle->bundles;
                    }
               $bundles = $bundleSubject->subjects;
               foreach ($bundles as $bundle) {
                  $subjects =  $bundle->subjects->where('id',$subject_id)->first();
                  return $subjects->chapters->first()->lessons;
               }
                   return response()->json([
                'response' => $bundleSubject,
            ]);
             } catch (\Throwable $th) {
                //throw $th;
             }
         
        } else {
            $status = 'This Student Has This Lesson';

            return response()->json([
                'success' => 'data return successfully',
                'data' => $lesson,
            ]);
        }
    }
}
