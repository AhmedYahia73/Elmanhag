<?php

namespace App\Http\Controllers\api\v1\admin\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class SubjectController extends Controller
{
    public function __construct(private User $user){}

    public function view(Request $request){
        // https://bdev.elmanhag.shop/admin/teacher/subjects
        // Keys
        // teacher_id
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $subjects = $this->user
        ->where('id', $request->teacher_id)
        ->with('teacher_subjects.category')
        ->first()->teacher_subjects;

        return response()->json([
            'subjects' => $subjects
        ]);
    }

    public function add(Request $request){
        // https://bdev.elmanhag.shop/admin/teacher/subjects/add
        // Keys
        // teacher_id, subject_id
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $user = $this->user
        ->where('id', $request->teacher_id)
        ->first();
        $user->teacher_subjects()->attach($request->subject_id); // Add subject to teacher using pivot table

        return response()->json([
            'success' => 'You add subject success'
        ]);
    }

    public function delete($id, Request $request){
        // https://bdev.elmanhag.shop/admin/teacher/subjects/add
        // Keys
        // teacher_id
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $user = $this->user
        ->where('id', $request->teacher_id)
        ->first();
        $user->teacher_subjects()->detach($id); // Add subject to teacher using pivot table

        return response()->json([
            'success' => 'You delete subject success'
        ]);
    }

}
