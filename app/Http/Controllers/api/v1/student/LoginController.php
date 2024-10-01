<?php

namespace App\Http\Controllers\api\v1\student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use GeoIP;
use App\Models\LoginHistory;
use App\Models\PersonalAccessToken;

use App\Http\Requests\api\student\LoginRequest;
use Hash;

class LoginController extends Controller
{
    public function __construct(private User $user, private LoginHistory $login_history,
    private PersonalAccessToken $tokens){}
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
        ->orwhere('phone',$login['email'])->first();
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
             
                    $os = $agent->platform();
                    $browser = $agent->browser();
                    $device = $agent->device();
                    $ip = $request->ip();
                    // $geoInfo = GeoIP::getLocation($ip);
                    // $country = $geoInfo['country'];
                    // $city = $geoInfo['city'];
                    // $location = "https://www.google.com/maps?q={$geoInfo['lat']},{$geoInfo['lon']}";
                    $start_session = now();
                    $token_id = $this->tokens
                    ->where('token', $token)
                    ->first();

                    $this->login_history
                    ->create([
                        'os' => $os,
                        'browser' => $browser,
                        'device' => $device,
                        'ip' => $ip,
                        // 'country' => $country,
                        // 'city' => $city,
                        // 'location' => $location,
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
            $logout = $user->tokens()->delete();
            if( $logout ){
                return response()->json([
                    'success'=>'Logout Successfully',
                ]);
            }
        }
        
    }

  
}
