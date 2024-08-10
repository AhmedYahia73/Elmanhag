<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\country;
use App\Models\city;
use App\Models\category;
use App\Models\User;

use App\Http\Requests\api\auth\SignupRequest;

class SignupController extends Controller
{

    protected $requestSignup = ['firstName','lastName', 'email', 'password',
    'parent_name', 'parent_phone', 'phone', 'city_id', 'country_id', 'category_id', 'language'];
    // Sign up Page

    public function  signup(){
        $countries = country::
        where('status', '1')
        ->get();
        $cities = city::
        where('status', '1')
        ->get();
        $categories = category::
        where('category_id', '!=', null)
        ->where('status', '1')
        ->get();

        return response()->json([
            'countries' => $countries,
            'cities' => $cities,
            'categories' => $categories,
        ]);
    }

    // Sign up Student Proccessing

    public function signup_proccess(SignupRequest $request){
        $data= $request->only($this->requestSignup);
        $data['type'] = 'student';
        $user = User::create($data);

        $token = $user->createToken('personal access Tokens')->plainTextToken;
        return response()->json([
            'success'=>'Sign Up Successfully',
            '_token'=>$token,
            'detailes'=>$data,
        ]);
        
    }
}
