<?php

namespace App\Http\Controllers\api\v1\parent\subjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\trait\student_subjects;

use App\Models\User;

class SubjectController extends Controller
{
    public function __construct(private User $users){}
    use student_subjects;

    public function subjects(Request $request){
        // https://bdev.elmanhag.shop/parent/subjects
        // Keys
        // student_id
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $student_id = $request->student_id;
        $subjects = $this->student_subject($student_id); // Get subjects
        $lessons = collect([]);
        foreach ($subjects as $subject) {
            foreach ($subject->chapters as $item) {
                $lessons = $lessons->merge($item->lessons); // Get lessons
            }
        }
        $lesson_count = count($lessons);
        $subjects_ids = $subjects->pluck('id'); // Get subjects ids
        $student_homework = $this->users
        ->with('user_homework')
        ->where('id', $student_id)
        ->first()->user_homework; // Get homework that student solve it

        $success_homeworks = [];
        // homework that student success in it
        foreach ($student_homework as $item) {
            if ($item->pass <= $item->pivot->score) {
                $success_homeworks[$item->id] = $item;
            }
        }

        $progress = 0;

        foreach ($success_homeworks as $item) {
            if ($item->title == 'H.W1') {
                $progress += 50;
            }
            elseif ($item->title == 'H.W2') {
                $progress += 35;
            }
            elseif ($item->title == 'H.W3') {
                $progress += 15;
            }
        }

        if ($lesson_count == 0) {
            $progress = 0;
        }
        else {
            $progress = $progress / $lesson_count;
        }

        return response()->json([
            'subjects' => $subjects,
            'progress' => $progress,
        ]);
    }

    public function subjects_progress(Request $request){
        // https://bdev.elmanhag.shop/parent/subjects
        // Keys
        // student_id
        
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $student_id = $request->student_id;
        $subjects = $this->student_subject($student_id); // Get subjects
        foreach ($subjects as $subject) {
            $lessons = collect([]);
            foreach ($subject->chapters as $item) {
                $lessons = $lessons->merge($item->lessons); // Get lessons
            }
            $lesson_count = count($lessons);
            $subjects_ids = $subjects->pluck('id'); // Get subjects ids
            $student_homework = $this->users
            ->with('user_homework', function($query) use($lessons){
                $query->whereIn('user_homework.lesson_id', $lessons->pluck('id'));
            })
            ->where('id', $student_id)
            ->first(); // Get homework that student solve it
            return response()->json([
                'student_homework' => $student_homework
            ]);
            $success_homeworks = [];
            // homework that student success in it
            foreach ($student_homework as $item) {
                if ($item->pass <= $item->pivot->score) {
                    $success_homeworks[$item->id] = $item;
                }
            }
    
            $progress = 0;
    
            foreach ($success_homeworks as $item) {
                if ($item->title == 'H.W1') {
                    $progress += 50;
                }
                elseif ($item->title == 'H.W2') {
                    $progress += 35;
                }
                elseif ($item->title == 'H.W3') {
                    $progress += 15;
                }
            }
    
            if ($lesson_count == 0) {
                $progress = 0;
            }
            else {
                $progress = $progress / $lesson_count;
            }
        }

        return response()->json([
            'subjects' => $subjects,
            'progress' => $progress,
        ]);
    }
}
