<?php

namespace App\Http\Controllers\api\v1\student\setting;

use App\Models\city;
use App\Models\country;
use App\Models\category;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\ParentRelation;
use App\Http\Controllers\Controller;
use App\Models\StudentJob;

class SettingController extends Controller
{
 // This Controller About All Data Setting For Student


    public function __construct(
        private country $country,
        private city $city,
        private category $category,
        private Education $education,
        private ParentRelation $parentRelation,
        private StudentJob $studentJobs,
    ){}

    public function show(){
        $country = $this->country::orderBy('name')->get();
        $city = $this->city::orderBy('name')->where('country_id','!=',null)->get();
        $category = $this->category::orderBy('name')->get();
        $education = $this->education::orderBy('name')->get();
        $parentRelation = $this->parentRelation::orderBy('name')->get();
        $studentJobs = $this->studentJobs::get();
        

        return response()->json(
        [
            'success'=>'Data Returned Successfully',
            'country'=>$country,
            'city'=>$city,
            'category'=>$category,
            'education'=>$education,
            'parentRelation'=>$parentRelation,
            'studentJobs'=>$studentJobs,
        ],200);
    }
}
