<?php

namespace App\Http\Controllers\api\v1\student;

use App\Models\User;
use App\Models\category;
use App\Models\Education;
use App\Models\StudentJob;
use App\trait\image;
use Faker\Provider\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\student\SignupRequest;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupNotificationMail;

class SignupController extends Controller
{
        public function __construct(private User $user, private category $category,
        private Education $education, private StudentJob $student_job) {}

   protected $studentRequest = [
   'name',
   'email',
   'password',
   'phone',
   'city_id',
   'country_id',
   'category_id',
   'role',
   'gender',
   'sudent_jobs_id',
   'parent_relation_id',
   'education_id',
   'affilate_id',
    'parent_id',
   'language'
   ];
    protected $parentRequest = [
    'parent_name',
    'parent_email',
    'parent_password',
    'parent_phone',
    'parent_role',
  
    'parent_relation_id',
    ];
    // This Controller About Create New Student
    use image;
    public function store(SignupRequest $request){
    //  try {
    //     // This Email Must Be Email Login With Mailtrab
    //        Mail::to('ziadm57@yahoo.com')->send(new SignupNotificationMail([$request]));
    //  } catch (\Throwable $th) {
    //         return response()->json([
    //             'faield'=>'Something Wrong Send Email Faield',
    //         ],500);
    //  }
    //     return response()->json([
    //         'success'=>'Welcome,Student Created Successfully'
    //     ],200);
        $newStudent = $request->only($this->studentRequest); // Get Requests
        $image_path = $this->upload($request,'image', 'student/user'); // Upload New Image For Student
       if (empty($image_path) || $image_path == null) {
            if ($newStudent['gender'] == 'male') {
                $newStudent['image'] = 'default.png';
            } else {
                $newStudent['image'] = 'female.png';
            }
       } 
       else {
            $newStudent['image'] = $image_path;
       }
        $newStudent['role'] = 'student';
         if(isset($request->affilate_code)){ // If Student Append Affiliate Code
            $affiliate = $this->user->where('affilate_code', $request->affilate_code)->first();
            $newStudent['affilate_id'] = $affiliate->id;
         }
        
        
        if($this->parentRequest){
            $parent = $this->user
            ->where('email', $newParent['parent_email'])
            ->first();
            if (empty($parent)) {
                $newParent = $request->only($this->parentRequest);
                //   $newParent['parent_id'] = $user->id;
                  $newParent['role'] = 'parent';
                  $parent = $this->user->create([
                  'name' => $newParent['parent_name'],
                  'email' => $newParent['parent_email'],
                  'password' => $newParent['parent_password'],
                  'phone' => $newParent['parent_phone'],
                  'role' => 'parent',
                  'parent_relation_id' => $newParent['parent_relation_id'],
                  ]); // Start Create Parent
            }
        }
        $newStudent['parent_id'] = $parent->id; // Relational Parent With Student
        $user = $this->user->create($newStudent); // Start Create New Student
        $token = $user->createToken('personal access token')->plainTextToken; // Start Create Token
        $user->token = $token; // Start User Take This Token ;
        // $user->category = $this->category
        // ->where('id', $user->category_id )
        // ->first()->name;
        // $user->education = $this->education
        // ->where('id', $user->education_id  )
        // ->first()->name;
        // $user->job = $this->student_job
        // ->where('id', $user->sudent_jobs_id)
        // ->first()->job;
        // $user->parent = $request->parent_name;
        // Mail::to('ahmedahmadahmid73@gmail.com')->send(new SignupNotificationMail($user));
        return response()->json([
            'success'=>'Welcome,Student Created Successfully',
            'user'=>$user,
            '_token'=>$token,
        ],200);
        
    }
}
