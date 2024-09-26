<?php

namespace App\Http\Controllers\api\v1\teacher;

use App\Http\Controllers\Controller;
use App\Models\Live;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiveSessionsController extends Controller
{
    // This Controller About Live Sessions Teacher
    public function __construct(private Live $live)
    {
    }
    public function show(Request $request): JsonResponse
    {
        $teacher = $request->user();
        $liveSessions = $teacher->liveSessions;
        if (count($liveSessions) === 0) {
            return response()->json([
                    'faield'=>'Not Found any Sessions',
            ], 204);
        }
        return response()->json([
            'sessions' => $liveSessions,
        ], 200);
    }
}
