<?php

namespace App\Http\Controllers\api\v1\student\correct;

use App\Http\Controllers\Controller;
use App\Models\homework;
use Illuminate\Http\Request;

class CorrectingHomeWork extends Controller
{
    // This Is Controller About Correct Home Worke
public function __construct(private homework $homework) {}
    public function store(Request $request){
                // Start Store Correct HomeWork

        $user = $request->user();
        $user_id = $user->id;
        $homework_id = $request->homework_id;
        $homework = $this->homework;
        $homework->user_homework()->sync([$user_id,$homework_id],$user_id);

    }
}
