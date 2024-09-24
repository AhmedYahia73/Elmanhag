<?php

namespace App\Http\Controllers\api\v1\student\liveSession;

use App\Http\Controllers\Controller;
use App\Models\Live;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    // feat => This About Get All Live Sessions For Student

    public function  __construct(private Live $live) {}
        public function show(Request $request){
        $user = $request->user();
        $user_category = $user->category_id; 
        $user_education = $user->education_id; 
        $session_id = $request->session_id;
                try {
                      $student = $user->where('id', $user->id)->with('bundles.subjects')->with('subjects')
                      ->first();    
           $bundles = $student->bundles;
            $subject_list = collect([]);
                      foreach ($bundles as $bundle) {
                            $bundle_subjec =  $bundle->subjects->pluck('id');
                    $subject_list = $subject_list->merge( $bundle_subjec);
                            $subjects_id = $student->subjects->pluck('id');
                    $subject_list = $subject_list->merge($subjects_id);
                        $live = $this->live;
                               $sessions = $live
                                ->whereIn('subject_id',$subject_list)
                                ->where('inculded',true)
                                ->where('id',$session_id)    
                                ->first();
                      }     
                       
                } catch (QueryException $queryException) {
                        return response()->json([
                            'faield'=>'Something wrong!'
                        ],400);
                }
     
        $student_subject = $user->subjects;
        return response()->json(
         data:[
            'success'=>'data returned successfully',
            'liveSession'=>$sessions,
            // 'subject'=>$student_subject,
        ]
            
        ,status: 200);
        
    }
}
