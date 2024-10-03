<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\admin\affilate\AffilateRequest;
use App\Http\Requests\api\affiliate\AfilliateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    // This Controller About Affiliate
    protected $requestAffiliate = ['name','affilate_code','email','phone','status','role','country_id','city_id','password'];
        public function __construct(private User $user){}
    protected $requestAccountAfilliate = ['affilate_id'];
    public function store(AfilliateRequest $request){
        $newAffilate =  $request->only($this->requestAffiliate);
        $newAffilate['role'] ='affilate';
        $user = $this->user ;

        do {
            $length = 6;
          // Generate a random number of the desired length
            $min = pow(10, $length - 1); // Minimum number based on length (e.g., 1000000000 for 10 digits)
            $max = pow(10, $length) - 1; // Maximum number based on length (e.g., 9999999999 for 10 digits)
            $randomNumber = random_int($min, $max);

          // Check if this number already exists in the database
          $exists = $this->user::where('affilate_code', $randomNumber)->exists();
          $newAffilate['affilate_code'] = $randomNumber;
          } while ($exists); // Repeat until a unique number is generated

        $user = $user->create($newAffilate);
        $newAffilate['image'] = 'default.png';
        $newAffilate['status'] = Null;
        $affiliate =['affilate_id'=> $user->id];
        $user->income()->create($affiliate);
        $token = $user->createToken('personal access token')->plainTextToken; // Start Create Token
        $user->token = $token; // Start User Take This Token ;
        $user->image = 'default.png'; // Start User Take This Token ;
        Mail::to('elmanhagedu@gmail.com')->send(new SignupNotificationMail($user,$subject,$view));
        return response()->json([
            'success'=>'affilate Add Successfully',
            '_tokent'=>$token,
            'user' => $user],200);
    }



}
