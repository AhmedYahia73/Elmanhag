<?php

namespace App\Http\Controllers\api\v1\admin\student;

use App\trait\image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\api\admin\student\StudentRequest;
use App\Http\Requests\api\admin\student\UpdateStudentRequest;

use App\Models\User;

class CreateStudentController extends Controller
{
    public function __construct(private User $user){

    }
    protected $studentRequest = [
        'name',
        'phone',
        'role',
        'email',
        'category_id',
        'language',
        'password',
        'country_id',
        'city_id',
    ];
    // This Controller About Student
    use image;
    public function store(StudentRequest $request){
        $newStudent =  $request->only($this->studentRequest); // Take only Request From Protected studentRequest names 
        $newStudent['role'] = 'student'; // Type Of User
        $user = $this->user->create($newStudent); // Start Create New Studetn
        $parent = $this->user->create([
            'name' => $request->parent_name,
            'email' => $request->parent_email,
            'password' => $request->parent_password,
            'phone' => $request->parent_phone,
            'role' => 'parent',
            'student_id' => $user->id,
            'parent_relation_id' => $request->relation_id,
        ]); // Start Create Parent
        return response()->json(['success'=>'Student Created Successfully'],200); 
    }
    
    public function modify(UpdateStudentRequest $request, $id){
        // Take only Request From Protected studentRequest names 
        $student =  $request->only($this->studentRequest); 
        // Get User Data
        $user = User::where('id', $id)
        ->where('role', 'student')
        ->first();
        // Update Image
        if ( !empty($user) ) {
            $image =  $this->upload($request,'image','student/user'); // Start Upload Image
            // If new image is found delete old image
            if ( !empty($image) && $image != null ) {
                $this->deleteImage($user->image);
                $student['image'] =$image; // Image Value From traid Image 
            }
            $user->update($student); // Start Create New Studetn
            return response()->json(['success'=>'Student Updated Successfully'],200); 
        }
        else{
            return response()->json(['faild'=>'Student Is not Found'],400); 
        }
    }

    public function delete( $id ){
        // Get User Data
        $user = User::where('id', $id)
        ->where('role', 'student')
        ->first();

        // Remove User
        if ( !empty($user) ) {
            $this->deleteImage($user->image);
            $user->delete();
            return response()->json(['success'=>'Student Deleted Successfully'],200); 
        }
        else{
            return response()->json(['faild'=>'Student Is not Found'],400); 
        }
    }
   
}
