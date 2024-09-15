<?php

namespace App\Http\Controllers\api\v1\parent\subjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\trait\student_subjects;
 

class SubjectController extends Controller
{
    public function __construct(){}

    public function subjects(Request $request){
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $student_id = $request->student_id;
        $subjects = $this->student_subject($student_id);

        return response()->json([
            'subjects' => $subjects,
        ]);
    }
}
