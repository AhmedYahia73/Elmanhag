<?php

namespace App\Http\Controllers\api\v1\admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileAdminController extends Controller
{
    // This Is Controller About Admin Profile


    public function view(Request  $request){
            
        if($request){
             $user = $request->user()->with('country')->with('city')->first();
                return response()->json([
                'success'=>'Get User Profile Successfully',
                'user'=>$user,
                ],200);
        }else{
             return  response()->json([
               'message'=>'validation error',
               'errors'=>$request->errors(),
               ],401);
        }
      
           
    }

     
}
