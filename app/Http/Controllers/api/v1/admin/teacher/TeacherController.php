<?php

namespace App\Http\Controllers\api\v1\admin\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\teacher\TeacherRequest;
use App\Http\Requests\api\admin\teacher\AddTeacherRequest;
use App\trait\image;

use App\Models\User;
use App\Models\category;
use App\Models\subject;

class TeacherController extends Controller
{
    use image;
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

    public function teacher_profile($id){
        $teacher = $this->users->where('id', $id)
        ->where('role', 'teacher')
        ->first();

        return response()->json([
            'teacher' => $teacher
        ]);
    }

    public function teacher_profile_update(TeacherRequest $request, $id){ 
        // Get User Data
        $user = User::where('id', $id)
        ->where('role', 'teacher')
        ->first();
        // Update Image
        if ( !empty($user) ) {
            $image =  $this->upload($request,'image','teacher/user'); // Upload teacher image
            
            // If new image is found delete old image
            if ( !empty($image) && $image != null ) { 
                $this->deleteImage($user->image['path']); // Delete old teacher image
                $user->image = $image;
            }
             
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = $request->password;
            }

            $user->save(); // Start Update Teacher Data

            $user->teacher_subjects()->sync($request->subject);
            return response()->json(['success'=>'Teacher Updated Successfully'],200); 
        }
        else{
            return response()->json(['faild'=>'Teacher Is not Found'],400); 
        }
    }

    protected $teacherRequest = [
        'name',
        'phone',
        'name',
        'name',
    ];
    public function add_teacher(AddTeacherRequest $request){ 
        // Update Image
        if ( !empty($user) ) {
            $image =  $this->upload($request,'image','teacher/user'); // Upload teacher image
             
            // $user-> = $request->name;
            // $user-> = $request->phone;
            // $user->status = $request->status;
            // $user->email = $request->email;
            // $user->role = 'teacher';
            if ($request->filled('password')) {
                $user->password = $request->password;
            }

            $user->save(); // Start Update Teacher Data

            $user->teacher_subjects()->sync($request->subject);
            return response()->json(['success'=>'Teacher Updated Successfully'],200); 
        }
        else{
            return response()->json(['faild'=>'Teacher Is not Found'],400); 
        }
    }
}
