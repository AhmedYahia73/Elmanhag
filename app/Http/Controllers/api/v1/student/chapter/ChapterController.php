<?php

namespace App\Http\Controllers\api\v1\student\chapter;

use App\Http\Controllers\Controller;
use App\Models\chapter;
use App\Models\subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    // This Controller About All Student Chapters
    
            public function __construct(private chapter $chapter,private subject $subject){
            }
               public function show(Request $request){
                        $user = $request->user(); 
                        $category_user = $user->category_id; 
                        $validator = Validator::make($request->all(), [
                        'subject_id' => 'required|exists:chapters',
                        ]);
                        
                        if ($validator->fails()) { // if Validate Make Error Return Message Error
                                return response()->json([
                                        'error' => $validator->errors(),
                                ],400);
                        }
                        $subject_id = $request->subject_id;
                        $category_subject = $this->subject->where('id', $subject_id)->first();
                                if($category_user != $category_subject->category_id) {
                                        return response()->json([
                                        'error' => 'This Subject Dont Have any Chapter For This Category',
                                        ],404);
                                }
                        try {
                        $chapter = $this->chapter
                        ->where('subject_id',$subject_id)
                        ->with('lessons')
                        ->get();
                        
                        } catch (QueryException $th) {
                                return response()->json([
                                'faild'=>'Not Found Lesson',
                                'error'=>$th,
                                ]);
                        }
                        return response()->json([
                                'success'=>'data Returned Successfully',
                                'chapter'=>$chapter,
                        ],200);
        }

        
}
