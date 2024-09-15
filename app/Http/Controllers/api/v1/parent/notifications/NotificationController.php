<?php

namespace App\Http\Controllers\api\v1\parent\notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\trait\student_subjects;

use App\Models\User;
use App\Models\homework;

class NotificationController extends Controller
{
    public function __construct(private User $users, private homework $homeworks){}
    use student_subjects;
    
    public function show(Request $request){
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
        $subjects_ids = $subjects->pluck('id'); // Get subjects ids
        

        return response()->json([
            'subjects' => $subjects_ids,
        ]);
    }
}
