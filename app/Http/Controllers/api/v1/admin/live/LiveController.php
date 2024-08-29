<?php

namespace App\Http\Controllers\api\v1\admin\live;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Live;
use App\Models\User;
use App\Models\subject;

class LiveController extends Controller
{
    public function __construct(private Live $live, 
    private User $users, private subject $subject){}

    public function show(){
        $live = $this->live
        ->with(['subject', 'teacher'])
        ->get();
        $teachers = $this->users
        ->where('role', 'teacher')
        ->get();
        $subjects = $this->subject
        ->get();

        return response()->json([
            'live' => $live,
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }
}
