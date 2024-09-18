<?php

namespace App\Http\Controllers\api\v1\student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\api\student\LoginRequest;
use Hash;
class LoginController extends Controller
{
    public function __construct(private User $user){}
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
        // return $user->password . ' '. bcrypt($login['password']);
        $error = response()->json([
        'faield'=>'creational not Valid',
        ]);
        if(!$user)
            {
                  return response()->json([
                  'faield'=>'creational not Valid',
                  ]);
            }
        if( !password_verify($request->input('password'),$user->password)){
                return $error ;
       }
                $token = $user->createToken('personal access token')->plainTextToken;
                $user->token = $token;
                if(!empty($user->role)){
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
