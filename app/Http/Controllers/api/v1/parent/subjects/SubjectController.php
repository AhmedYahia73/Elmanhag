<?php

namespace App\Http\Controllers\api\v1\parent\subjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;
use App\Models\bundle;

class SubjectController extends Controller
{
    public function __construct(private subject $subject, private bundle $bundle){}

    public function subjects(Request $request){
        $student_id = $request->student_id;
        $subjects = $this->subject
        ->whereHas('users', function($query) use($student_id){
            $query->where('id', $student_id);
        })
        ->get(); // Get subjects of student
    }
}
