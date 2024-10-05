<?php

namespace App\Http\Controllers\api\v1\student\setting;

use App\Models\city;
use App\Models\country;
use App\Models\category;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\ParentRelation;
use App\Http\Controllers\Controller;
use App\Models\AffilateGroupVideos;
use App\Models\AffilateVideos;
use App\Models\PaymentMethodAffilate;
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
        private PaymentMethodAffilate $paymentMethodAffilate,
        private AffilateGroupVideos $affilateGroupVideos,
    ){}

    public function show(){
        $country = $this->country::get();
        $city = $this->city::orderBy('id')->where('country_id','!=',null)->get();
        $category = $this->category::where('category_id', '!=', null)->orderBy('order')->get();
        $education = $this->education::orderBy('name')->get();
        $parentRelation = $this->parentRelation::orderBy('name')->get();
        $studentJobs = $this->studentJobs::get();
        $paymentMethodAffilate = $this->paymentMethodAffilate::get();

        return response()->json(
        [
            'success'=>'Data Returned Successfully',
            'country'=>$country,
            'city'=>$city,
            'category'=>$category,
            'education'=>$education,
            'parentRelation'=>$parentRelation,
            'studentJobs'=>$studentJobs,
            'paymentMethodAffilate'=>$paymentMethodAffilate,
        ],200);
    }

    public function videos_explain(Request $request){
            $affiliate_group_video = $this->affilateGroupVideos::with('affilate_videos')->get();

        return response()->json([
            'success'=>'Data Returned Successfully',
            'affiliate_group_video'=>$affiliate_group_video,
        ]);
    }
}
