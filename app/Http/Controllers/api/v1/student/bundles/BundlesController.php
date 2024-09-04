<?php

namespace App\Http\Controllers\api\v1\student\bundles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\bundle;
use App\Models\subject;
use App\Models\Live;

class BundlesController extends Controller
{
    public function __construct(private bundle $bundles, private subject $subjects, private Live $live){}
    
    public function show(){
        $bundles = $this->bundles
        ->where('category_id', auth()->user()->category_id)
        ->whereDoesntHave('users')
        ->get(); // Get bundles that havs the same category of student and student does not buy it
        $subjects = $this->subjects
        ->where('category_id', auth()->user()->category_id)
        ->whereDoesntHave('users')
        ->get(); // Get subject that havs the same category of student and student does not buy it
        $live = $this->live
        ->whereHas('subject', function($query) {
            $query->where('category_id', auth()->user()->category_id);
        })
        ->get(); // Get live that havs the same category of student

        return response()->json([
            'bundles' => $bundles,
            'subjects' => $subjects,
            'live' => $live,
        ]);
    }
}
