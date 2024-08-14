<?php

namespace App\Http\Controllers\api\v1\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\country;
use App\Models\city;
use App\Models\category;
use App\Models\User;

use App\Http\Requests\api\student\ProfileRequest;

class ProfileController extends Controller
{
    protected $profil_data = ['firstName', 'lastName', 'category_id', 'language',
    'country_id', 'city_id', 'phone', 'parent_name', 'parent_phone'];

    public function index( Request $request ){

        $user_data = $request->user()
            ->with('city')->with('country')->first();
            
        return response()->json([
            'user_data' => $user_data,
        ]);
    }

    public function update_profile( ProfileRequest $request ){
        $data = $request->only($this->profil_data);
        User::where( 'id', auth()->user()->id )
        ->update($data);

        return response()->json([
            'success' => 'You Are Updated Success'
        ]);
    }
}
