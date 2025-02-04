<?php

namespace App\Http\Controllers\api\v1\student\recorded_live;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LiveRecorded;
use App\Models\subject;
use App\Models\bundle;

class RecordedLiveController extends Controller
{
    public function __construct(private LiveRecorded $live_recorded, private subject $subjects,
    private bundle $bundles){}

    public function show(){
        // https://bdev.elmanhag.shop/student/recorded_live
        $bundles = $this->bundles
        ->where('category_id', auth()->user()->category_id)
        ->whereHas('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->with('subjects')
        ->get(); // Get bundles that havs the same category of student and student buy it
        $bundles = $bundles->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));
        $bundles_subjects = [];
        foreach ($bundles as $item) {
            $bundles_subjects = array_merge($bundles_subjects, 
            $item->subjects->pluck('id')->toArray());
        } 
        $subjects = $this->subjects
        ->where('category_id', auth()->user()->category_id)
        ->whereHas('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->orWhereIn('id', $bundles_subjects)
        ->where('category_id', auth()->user()->category_id)
        ->get(); // Get subject that havs the same category of student and student buy it

        $subjects = $subjects->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));
        $user_id = auth()->user()->id;
        $live_recorded = $this->live_recorded
        ->whereIn('subject_id', $subjects->pluck('id'))
        ->where('active', 1)
        ->orWhere('paid', 0)
        ->where('active', 1)
        ->where('category_id', auth()->user()->category_id)
        ->orWhereHas('user', function($query) use($user_id){
            $query->where('users.id', $user_id);
        })
        ->where('active', 1)
        ->with(['category', 'chapter', 'lesson'])
        ->get();

        return response()->json([
            'live_recorded' => $live_recorded,
        ]);
    }
}
