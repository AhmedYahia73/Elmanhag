<?php

namespace App\Http\Controllers\api\v1\student;

use App\Models\User;
use App\Models\category;
use App\Models\Education;
use App\Models\StudentJob;
use App\services\GeoService;
use Jenssegers\Agent\Agent;
use App\Models\LoginHistory;
use App\Models\PersonalAccessToken;
use Carbon\Carbon;
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
        private Education $education, private StudentJob $student_job, private LoginHistory $login_history,
        private PersonalAccessToken $tokens, GeoService $geoService) {
        $this->geoService = $geoService;}

protected $geoService;
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
                if($affiliate){
                     $newStudent['affilate_id'] = $affiliate->id;
                }
         }
        
        
        if($this->parentRequest){
            $newParent = $request->only($this->parentRequest);
            //   $newParent['parent_id'] = $user->id;
            $parent_phone = '012' . rand(100000, 999999);
            $parent = $this->user->where('phone', $parent_phone)
            ->first();
            while (!empty($parent)) {
                $parent_phone = '012' . rand(100000, 999999);
                $parent = $this->user->where('phone', $parent_phone)
                ->first();
            }
            $newParent['role'] = 'parent';
            $parent = $this->user->create([
            'name' => 'parent ' . $newStudent['name'],
            'email' => $parent_phone . '@elmanhag.com',
            'password' => $newParent['parent_password'],
            'phone' => $parent_phone,
            'role' => 'parent',
            'parent_relation_id' => $newParent['parent_relation_id'],
            ]); // Start Create Parent
        }
        $newStudent['parent_id'] = $parent->id; // Relational Parent With Student
        $user = $this->user->create($newStudent); // Start Create New Student
        $token = $user->createToken('personal access token')->plainTextToken; // Start Create Token
        $user->token = $token; // Start User Take This Token ;
            //  Get location
                    $agent = new Agent();
                    $agent->setUserAgent($request->header('User-Agent'));
                    $ip = $request->ip(); // Get the user's IP address
                    $location = $this->geoService->getLocation($ip);

                    $os = $agent->platform();
                    $browser = $agent->browser();
                    $device = $agent->device();
                    $ip = $request->ip();
                    // $geoInfo = GeoIP::getLocation($ip);
                    $country = $location['country'] ?? null;
                    $city = $location['city'] ?? null;
                    $location = "https://www.google.com/maps?q={$location['loc']}";

                    $start_session = now();
                    $token_id = $user->logins->id;

                    $login_history = $this->login_history
                    ->create([
                    'os' => $os,
                    'browser' => $browser,
                    'device' => $device,
                    'ip' => $ip,
                    'country' => $country,
                    'city' => $city,
                    'location' => $location,
                    'start_session' => $start_session,
                    'user_id' => $user->id,
                    'token_id' => $token_id,
                    ]);
            //  Get location
        $user->category = $this->category
        ->where('id', $user->category_id )
        ->first()->name;
        $user->education = $this->education
        ->where('id', $user->education_id  )
        ->first()->name;
        $user->job = $this->student_job
        ->where('id', $user->sudent_jobs_id)
        ->first()->job;
        $user->parent = $request->parent_name;
        $user->parent_phone = $request->parent_phone;
        $subject = "Signup Notification Mail";
        $view = "Signup";
         Mail::to('elmanhagedu@gmail.com')->send(new SignupNotificationMail($user,$subject,$view));

        return response()->json([
            'success'=>'Welcome,Student Created Successfully',
            'user'=>$user,
            '_token'=>$token,
        ],200);
        
    }
}
