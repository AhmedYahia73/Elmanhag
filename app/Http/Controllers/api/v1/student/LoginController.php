<?php

namespace App\Http\Controllers\api\v1\student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\services\GeoService;
use Jenssegers\Agent\Agent;
use GeoIP;
use App\Models\LoginHistory;
use App\Models\PersonalAccessToken;
use Carbon\Carbon;

use App\Http\Requests\api\student\LoginRequest;
use Hash;

class LoginController extends Controller
{
    protected $geoService;
    public function __construct(private User $user, private LoginHistory $login_history,
    private PersonalAccessToken $tokens, GeoService $geoService){
        $this->geoService = $geoService;
    }
    protected $loginRequest = [
        'email',
        'password',
    ];
    // This Is About Login ['Student','Affiliate','Parent']

    public function login(LoginRequest $request){
        $login = $request->only($this->loginRequest);
       $checkLogin =  is_numeric($login['email']) ? $name ='phone':$name ='email'; // Old Selution
        $user = $this->user
        ->where('email',$login['email'])
        ->orWhere('affilate_code',$login['email'])
        ->orWhere('phone',$login['email'])->first();
        if ($user->status == 0) {
            return response()->json([
                'success' => 'You are banned'
            ], 403);
        }
        // return $user->password . ' '. bcrypt($login['password']);
        $error = response()->json([
        'faield'=>'creational not Valid'
        ], 400);
        if(!$user)
            {
                  return response()->json([
                  'faield'=>'creational not Valid'
                  ], 400);
            }
        if( !password_verify($request->input('password'),$user->password)){
                return $error ;
       }
                $token = $user->createToken('personal access token')->plainTextToken;
                $user->token = $token;
                if(!empty($user->role) && $user->role != 'admin' && $user->role != 'supAdmin'){
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
                    
                   return response()->json([
                   'success'=>'Welcome '.$login['email'],
                   'user'=>$user,
                   'role'=>$user->role,
                   '_token'=>$token,
                   ]);
                }else{
                    return response()->json(['faield' => 'This user does not have the ability to login'],403);
                }
       
    }

    public function logout(Request $request){
        if(Auth::check()){
            $user = $request->user();
            $token_id = $user->currentAccessToken()->id;
            $end_session = now();
            $login_history = $this->login_history
            ->where('token_id', $token_id)
            ->orderByDesc('id')
            ->first(); // get login data
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $login_history->start_session);
            $end = Carbon::createFromFormat('Y-m-d H:i:s', now());
            $duration = $end->diff($start);
            
            $login_history->update([
                'end_session' => $end_session, 
                'duration' => $duration, 
            ]); // update login data
            $logout = $user->tokens()->delete();
            if( $logout ){
                return response()->json([
                    'success'=>'Logout Successfully',
                ]);
            }
        }
        
    }

  
}
