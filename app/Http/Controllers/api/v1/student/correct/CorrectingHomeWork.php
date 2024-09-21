<?php

namespace App\Http\Controllers\api\v1\student\correct;

use App\Http\Controllers\Controller;
use App\Models\homework;
use Illuminate\Http\Request;

class CorrectingHomeWork extends Controller
{
    // This Is Controller About Correct Home Worke
    public function __construct(private homework $homework) {}
    public function store(Request $request)
    {
        // Start Store Correct HomeWork

        $user = $request->user();
        $user_id = $user->id;
        $score = $request->score;
        $homework_id = $request->homework_id;
        $homework = $this->homework->where('id', $homework_id)->first();
        $lesson_id = $homework->lesson_id;
        if (count($user->user_homework) >= 1) {
            return response()->json([
                'faield' => 'This homework has been solved'
            ]);
        }
        $homework->user_homework()->attach([
            $user_id => [
                'user_id' => $user_id,
                'score' => $score,
                'lesson_id' => $lesson_id,
            ]
        ]);

        return response()->json([
            'success' => 'data Sent Successfully',
        ]);
    }
}
