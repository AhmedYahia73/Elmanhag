<?php

namespace App\Http\Controllers\api\v1\student\subsription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\bundle;
use App\Models\subject;
use App\Models\Live;

class SubscriptionController extends Controller
{
    public function __construct(private bundle $bundles, private subject $subjects, private Live $live){}
    
    public function view(){
        $bundles = $this->bundles
        ->where('category_id', auth()->user()->category_id)
        ->whereHas('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->with('subjects')
        ->get(); // Get bundles that havs the same category of student and student buy it
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
        ->whereNotIn('id', $bundles_subjects)
        ->get(); // Get subject that havs the same category of student and student does not buy it

      
        $live = $this->live
        ->where('category_id', auth()->user()->category_id)
        ->whereHas('students', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->where('inculded', 0)
        ->where('date', '>=', now())
        ->get(); // Get live that havs the same category of student

        $bundles = $bundles->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));
        $subjects = $subjects->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));
        return response()->json([
            'bundles' => $bundles,
            'subjects' => $subjects,
            'live' => $live,
        ]);
    }
}
