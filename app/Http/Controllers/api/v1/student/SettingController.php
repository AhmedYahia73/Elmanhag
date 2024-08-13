<?php

namespace App\Http\Controllers\api\v1\student;

use App\Http\Controllers\Controller;
use App\Models\city;
use App\Models\country;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // This Controller About All Data Setting For Student


    public function view(){
        $country = country::all()->sortBy('name');
        $city = city::all()->sortBy('name');
        

        return response()->json(
        [
            'country'=>$country,
            'city'=>$city,
        ]
        );
    }
}
