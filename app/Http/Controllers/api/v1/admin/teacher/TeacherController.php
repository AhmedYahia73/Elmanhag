<?php

namespace App\Http\Controllers\api\v1\admin\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\category;
use App\Models\subject;

class TeacherController extends Controller
{
    public function __construct(private User $users, private category $categories, 
    private subject $subject){}

    public function teachers_list(){
        $users = $this->users
        ->where('role', 'teacher'); // Get data of teacher
        $teachers = $users
        ->with('teacher_subjects.category')
        ->get(); // get teachers with its subjects and category of any subject
        $total_teachers = $users->count(); // count of all teachers
        $active_teachers = $users->where('status', 1)->count(); // count of active users
        $banned_teachers = $users->where('status', 0)->count(); // count of banned teachers
        $categories = $this->categories
        ->where('category_id', '!=', null)
        ->get(); // get categories
        $subjects = $this->subject->get(); // get subjects

        return response()->json([
            'teachers' => $teachers,
            'total_teachers' => $total_teachers,
            'active_teachers' => $active_teachers,
            'banned_teachers' => $banned_teachers,
            'categories' => $categories,
            'subjects' => $subjects,
        ]);
    }
}
