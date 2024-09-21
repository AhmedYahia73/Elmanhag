<?php

namespace App\Http\Controllers\api\v1\admin\live;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Live;
use App\Models\User;
use App\Models\subject;
use App\Models\category;
use App\Models\Education;

class LiveController extends Controller
{
    public function __construct(private Live $live, private category $category,
    private Education $education, private User $users, private subject $subject){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/live
        $live = $this->live
        ->with(['subject', 'teacher', 'category', 'education'])
        ->get();
        $teachers = $this->users
        ->where('role', 'teacher')
        ->get();
        $subjects = $this->subject
        ->get();
        $category = $this->category
        ->get();
        $education = $this->education
        ->get();

        return response()->json([
            'live' => $live,
            'teachers' => $teachers,
            'subjects' => $subjects,
            'category' => $category,
            'education' => $education,
        ]);
    }
}
