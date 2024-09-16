<?php

namespace App\Http\Controllers\api\v1\parent\notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\trait\student_subjects;
use Carbon\Carbon;

use App\Models\User;
use App\Models\homework;

class NotificationController extends Controller
{
    public function __construct(private User $users, private homework $homeworks){}
    use student_subjects;
    
    public function show(Request $request){
        // https://bdev.elmanhag.shop/parent/notification
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
        $subjects = $this->student_subject($student_id);
        $lessons = collect([]);
        foreach ($subjects as $subject) {
            foreach ($subject->chapters as $item) {
                $lessons = $lessons->merge($item->lessons);
            }
        }
        $subjects_ids = $subjects->pluck('id'); // Get subjects ids
        $student_homework = $this->users
        ->with('user_homework')
        ->where('id', $student_id)
        ->first()->user_homework; // Get homework that student solve it

        $success_homeworks = collect([]);
        // homework that student success in it
        foreach ($student_homework as $item) {
            if ($item->pass <= $item->pivot->score) {
                $success_homeworks->push($item);
            }
        }

        $homeworks = $this->homeworks
        ->whereDoesntHave('seen_notifications', function($query) use($student_id){
            $query->where('users.id', $student_id);
        })
        ->whereNotIn('id', $success_homeworks->pluck('id'))
        ->whereIn('lesson_id', $lessons->pluck('id'))
        ->with('subject')
        ->get(); // Get homework that in student subjects and paren not see it and student doesnot pass at it
        $old_homework = $homeworks
        ->where('due_date', '>', Carbon::now()->subDays(14))
        ->where('due_date', '<', now()); // Get old homework
        $due_homework = $homeworks
        ->where('due_date', '>', now())
        ->where('due_date', '<', Carbon::now()->addDays(1));

        return response()->json([
            'old_homework' => $old_homework,
            'due_homework' => $due_homework
        ]);
    }
}
