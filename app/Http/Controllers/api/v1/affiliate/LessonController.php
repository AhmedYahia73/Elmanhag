<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Models\lesson;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    // This Is About Start Use Lesson
    public function __construct(private lesson $lesson) {}
    public function show(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'lesson_id' => 'required',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }
        $lesson_id = $request->lesson_id;


        try {
            $lesson = $this->lesson
                ->where('id', $lesson_id)
                ->orderBy('order')
                ->where('paid', false)
                ->with('resources')
                ->with('homework')
                ->first(); // Start Get Leeon
        } catch (QueryException $queryException) {
            return response()->json([
                'error' => 'Something Wrong',
                'message' => $queryException->getMessage(),
            ]);
        }
            if($lesson == NULL){
                 return response()->json([
                 'faield' => 'Not Found Lesson Or This Lesson Is Paid',
                 ]);
            }
        return response()->json([
            'success' => 'Data Returned Successfully',
            'lesson' => $lesson,
        ]);
    }
}
