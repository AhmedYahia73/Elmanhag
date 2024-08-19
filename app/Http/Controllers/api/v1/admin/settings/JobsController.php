<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\settings\JobRequest;

use App\Models\StudentJob;

class JobsController extends Controller
{
    public function __construct(private StudentJob $jobs){}
    public function show(){
        $jobs = $this->jobs->get();

        return response()->json([
            'jobs' => $jobs
        ]);
    }

    public function create(JobRequest $request){

    }

    public function modify(JobRequest $request, $id){

    }

    public function delete($id){
        $this->jobs->where('id', $id)
        ->first()->delete();

        return response()->json([
            'success' => 'You delete job success'
        ]);
    }
}
