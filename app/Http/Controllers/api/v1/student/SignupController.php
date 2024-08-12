<?php

namespace App\Http\Controllers\api\v1\student;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\student\SignupRequest;
use App\Models\User;
use App\trait\image;
use Illuminate\Http\Request;

class SignupController extends Controller
{
        public function __construct(private User $user) {}
    protected $studentRequest = [
        'name',
        'email',
        'password',
        'parent_name',
        'parent_phone',
        'phone',
        'city_id',
        'country_id',
        'category_id',
        'type',
        'language'
    ];
    // This Controller About Create New Student
    use image;
    public function store(SignupRequest $request){
        $newStudent = $request->only($this->studentRequest); // Get Requests
        $image_path = $this->upload($request,'image', 'student'); // Upload New Image For Student
        $newStudent['image'] = $image_path;
        $newStudent['type'] = 'student';
        $user = $this->user->create($newStudent); // Start Create New Student
        $token = $user->createToken('personal access token')->plainTextToken; // Start Create Token
        $user->token = $token; // Start User Take This Token ;
        return response()->json([
            'success'=>'Welcome,Student Created Successfully',
            'user'=>$user,
            '_token'=>$token,
        ],200);
        
    }
}
