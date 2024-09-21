<?php

namespace App\Http\Controllers\api\v1\student;

use App\Http\Controllers\Controller;
use App\Models\homework;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HomeWorkController extends Controller
{
    // This Is About HomeWoke 
    public function __construct(private homework $homework){}
    public function show(Request $request){
         $homework_id = $request->homework_id;
        try {
        $homework = $this->homework->where('id', $homework_id)
            ->with('question_groups', function ($query) {
                    $query->with('questions', function ($query) {
                         $query->with('answers');
                    });
        })->first();
        } catch (QueryException $queryException) {
            return response()->json([
                'faield'=>'Not Found Homework',
                'homework'=>$queryException->getMessage(),
            ]);
        }
        return response()->json([
            'success'=>'Data Returned Successfully',
            'homework'=>$homework,
        ]);
    }
    
}
