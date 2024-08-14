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
        ->with('country')
        ->with('city')
        ->with('parents')
        ->with('category')
        ->where('id',$user_id )
        ->first();
        return response()->json([
            'success'=>'Hello '.$request->user()->name,
            'user'=>$user,
        ]);
    }
}
