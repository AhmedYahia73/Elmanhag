<?php

namespace App\Http\Controllers\api\v1\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;
use App\Models\bundle;

class SubjectsController extends Controller
{
    public function subjects( Request $request ){
        $subjects = subject::whereHas('users', function ($query) {
            $query->where('id', $request->user()->id);
        })
        ->where('expired_date', '>=', now())
        ->get();
        
        $bundels = bundle::whereHas('users', function ($query) {
            $query->where('id', $request->user()->id);
        })
        ->where('expired_date', '>=', now())
        ->with('subjects')
        ->get();

        return response()->json([
            'subjects' => $subjects,
            'bundels' => $bundels,
        ]);
    }
}
