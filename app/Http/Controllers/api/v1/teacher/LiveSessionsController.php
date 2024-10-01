<?php

namespace App\Http\Controllers\api\v1\teacher;

use App\Http\Controllers\Controller;
use App\Models\Live;
use App\Models\subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveSessionsController extends Controller
{
    // This Controller About Live Sessions Teacher
    public function __construct(
        private Live $live,
        private subject $subject
        )
    {
    }
    public function show(Request $request)
    {
       $user_id = $request->user()->id;
       $user = $request->user();
            try {
                 $teahcer_LiveSessions = $user->where('id',$user_id)->with('teacher_subjects',function($query):void{
                 $query->with('live');
                 })->first();
            } catch (QueryException $th) {
                    return response()->json([
                            'faield'=>'Something Wrong',
                            'message'=>$th->getMessage(),
                    ]);
            }
        $subject_sessions = $teahcer_LiveSessions['teacher_subjects'];

        return response()->json([
            'success' =>'data returned Successfully',
            'sessions' => $subject_sessions,
        ], 200);
    }
}
