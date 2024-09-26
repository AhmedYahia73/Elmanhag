<?php

namespace App\Http\Controllers\api\v1\admin\issues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class QuestionIssuesController extends Controller
{
    public function __construct(private User $users){}

    public function show(){
    }
}
