<?php

namespace App\Http\Controllers\api\v1\auth;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Http\Requests\api\auth\LoginRequest;

class LoginController extends Controller
{
    protected $requestLogin = ['email','password'];
    
    public function __construct(
        private User $user 
    ){
        
    }
    // This First Controller With Admin & Super Admin Login Api With App

    public function login(LoginRequest $request){
        $credentials= $request->only($this->requestLogin);
        $user_position = User::where('email', $request->email)
        ->first();
        if ( !empty($user_position) && ($user_position->role == 'admin' || $user_position->role == 'supAdmin') ) {
            
            $checkData = Auth::attempt($credentials);
            if(!$checkData){
                    return response()->json(['faild'=> 'Check Your credentials'],400);
            }else{
            $user =  $this->user->where('email', $credentials['email'])
            ->with('admin_position.roles')->first();
            if (!empty($user->admin_position)) {
                $user->roles = $user->admin_position->roles->pluck('role');
            }
            $token = $user->createToken('personal access Tokens')->plainTextToken;
                $user->token = $token;
                return response()->json([
                    'success'=>'Login Successfully',
                    '_token'=>$token,
                    'detailes'=>$user,
                ]);
            }
        }
        else{
            return response()->json(['faild'=> 'Check Your credentials'],400);
        }
        
    }
    // This First Controller With Login To Users Api With App

    public function user_login(LoginRequest $request){
        $credentials= $request->only($this->requestLogin);
        $user_position = User::where('email', $request->email)
        ->first();
        if ( !empty($user_position) && ($user_position->type != 'admin' && $user_position->type != 'supAdmin') ) {
            
            $checkData = Auth::attempt($credentials);
            if(!$checkData){
                    return response()->json(['faild'=> 'Check Your credentials'],400);
            }else{
            $user =  $this->user->where('email', $credentials['email'])->first();
            $token = $user->createToken('personal access Tokens')->plainTextToken;
                $user->token = $token;
                return response()->json([
                    'success'=>'Login Successfully',
                    '_token'=>$token,
                    'detailes'=>$user,
                ]);
            }
        }
        else{
            return response()->json(['faild'=> 'Check Your credentials'],400);
        }
        
    }

    public function logout(Request $request)
    {
    if($request->user()){
            $user =$request->user();
            $deletToken = $user->tokens()->delete();
            if ($deletToken) {
            return response()->json(['success'=>'User Logout Successfully']);
            }
        } else {
            return response()->json(['faild'=>'User Unauthorized']);
        }
       
    }


    
           
}
