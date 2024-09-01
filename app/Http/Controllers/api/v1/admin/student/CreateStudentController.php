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
        'education_id',
        'password',
        'country_id',
        'city_id',
        'status',
    ];
    // This Controller About Student
    use image;
    public function store(StudentRequest $request){
        // https://bdev.elmanhag.shop/admin/student/add?name=Ahmed&phone=146345&email=ahmed@gmail.com&parent_name=Aziz&parent_phone=167556&parent_email=sdfsdggbh@gmail.com&parent_password=123&category_id=1&education_id=39&password=123&country_id=71&city_id=42&status=1&relation_id=1
        $newStudent =  $request->only($this->studentRequest); // Take only Request From Protected studentRequest names 
        $newStudent['role'] = 'student'; // Type Of User
        $parent = $this->user->create([
            'name' => $request->parent_name,
            'email' => $request->parent_email,
            'password' => $request->parent_password,
            'phone' => $request->parent_phone,
            'role' => 'parent',
            'parent_relation_id' => $request->relation_id,
        ]); // Start Create Parent
        $newStudent['parent_id'] = $parent->id;
        $user = $this->user->create($newStudent); // Start Create New Studetn
        return response()->json(['success'=>'Student Created Successfully'],200); 
    }
    
    public function modify(UpdateStudentRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/student/update/22?name=Ahmed&phone=146345&email=ahmed@gmail.com&parent_name=Aziz&parent_phone=167556&parent_email=sdfsdggbh@gmail.com&parent_password=123&category_id=1&education_id=39&password=123&country_id=71&city_id=42&status=1
        // Take only Request From Protected studentRequest names 
        $student =  $request->only($this->studentRequest); 
        // Get User Data
        $user = User::where('id', $id)
        ->where('role', 'student')
        ->first();
        // Update Image
        if ( !empty($user) ) {
            $image =  $this->upload($request,'image','student/user'); // Upload teacher image
          
            // If new image is found delete old image
            if ( !empty($image) && $image != null ) { 
                $this->deleteImage($user->image['path']); // Delete old teacher image
                $data['image'] = $image;
            }

            $user->update($student); // Start Create New Studetn
            User::where('parent_id', $id)
            ->update([
                'name' => $request->parent_name,
                'phone' => $request->parent_phone,
                'email' => $request->parent_email,
                'password' => $request->parent_password,
                'parent_relation_id' => $request->relation_id,
            ]);
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
            $this->deleteImage($user->image['path']);
            $user->delete();
            return response()->json(['success'=>'Student Deleted Successfully'],200); 
        }
        else{
            return response()->json(['faild'=>'Student Is not Found'],400); 
        }
    }
   
}
