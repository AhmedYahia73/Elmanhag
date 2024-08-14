<?php

namespace App\Http\Controllers\api\v1\student\profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // This Controller About Profile Student

    public function profile(Request $request){
        // dd(Auth::user());
        $user_id = $request->user()->id;
        $user = $request->user()
        ->with('parents')
        ->where('id',$user_id )
        ->first();
         $user->education = $user->category->name;
         $user->country_name = $user->country->name;
         $user->city_name = $user->city->name;
        return response()->json([
            'success'=>'Hello '.$request->user()->name,
            'user'=>$user,
        ]);
    }
}
