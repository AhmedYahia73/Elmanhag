<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\settings\JobRequest;
use App\trait\translaion;

use App\Models\StudentJob;

class JobsController extends Controller
{
    protected $jodRequest = [
        'job',
        'title_male',
        'title_female',
        'ar_job',
        'ar_title_male',
        'ar_title_female',
    ];
    use translaion;
    public function __construct(private StudentJob $jobs){}
    public function show(){
        // https://bdev.elmanhag.shop/admin/Settings/jobs
        $jobs = $this->jobs->get();

        return response()->json([
            'jobs' => $jobs
        ]);
    }

    public function create(JobRequest $request){
        // https://bdev.elmanhag.shop/admin/Settings/jobs/add
        // key
        // job, title_male, title_female, ar_job, ar_title_male, ar_title_female
        $job_data = $request->only($this->jodRequest);
        $this->translate($job_data['job'], $job_data['ar_job']);
        $this->translate($job_data['title_male'], $job_data['ar_title_male']);
        $this->translate($job_data['title_female'], $job_data['ar_title_female']);
        $this->jobs->create($job_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(JobRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/Settings/jobs/update/{id}
        // key
        // job, title_male, title_female, ar_job, ar_title_male, ar_title_female
        $job_data = $request->only($this->jodRequest);
        $this->translate($job_data['job'], $job_data['ar_job']);
        $this->translate($job_data['title_male'], $job_data['ar_title_male']);
        $this->translate($job_data['title_female'], $job_data['ar_title_female']);
        $this->jobs->where('id', $id)
        ->first()
        ->update($job_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/Settings/jobs/delete/{id}
        $this->jobs->where('id', $id)
        ->first()->delete();

        return response()->json([
            'success' => 'You delete job success'
        ]);
    }
}
