<?php

namespace App\Http\Controllers\api\v1\student\setting;

use App\Http\Controllers\Controller;
use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function __construct(
        private subject $subject
    ){}
    //This Controller About All Subject

    public function show(int $education_id,){
        
        return response()->json(['success'=>'Successfully']);


    }
}
