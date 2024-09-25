<?php

namespace App\Http\Controllers\api\v1\admin\studenT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\subject;

class SubjectController extends Controller
{
    public function __construct(private User $users, private subject $subjects){}

    public function progress($id){
        $data = [];
        $subject = $this->subjects
        ->where('id', $id)
        ->first(); // Get subject
        $students = $subject->users->where('category_id', $subject->category_id);

        foreach ($students as $student) {
            $lessons = collect([]);
            foreach ($subject->chapters as $item) {
                $lessons = $lessons->merge($item->lessons); // Get lessons
            }
            $lesson_count = count($lessons); 
            $student_homework = $this->users
            ->with('user_homework')
            ->where('id', $student->id)
            ->first()->user_homework; // Get homework that student solve it
            $student_homework = $student_homework
            ->whereIn('lesson_id', $lessons->pluck('id'));
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
            $data[] = [
                'student' => $student,
                'progress' => $progress,
            ];
        }

        return response()->json($data);
    }
}
