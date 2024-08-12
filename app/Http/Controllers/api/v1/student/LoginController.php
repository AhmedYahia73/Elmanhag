<?php

namespace App\Http\Controllers\api\v1\student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\api\student\LoginRequest;

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
           if( Auth::attempt($login)){
                $user = $this->user->where('email',$login['email'])->first();
                $token = $user->createToken('personal access token')->plainTextToken;
                $user->token = $token;
                if($user->type == 'student'){
                    return response()->json([
                    'success'=>'Welcome '.$login['email'],
                    'user'=>$user,
                    'type'=>$user->type,
                    '_token'=>$token,
                    ]);
                }
                 
            }else{
                return response()->json([
                'faield'=>'creational not Valid',
                ]);
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
