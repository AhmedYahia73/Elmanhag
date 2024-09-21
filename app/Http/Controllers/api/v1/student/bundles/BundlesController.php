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
        ->where('education_id', auth()->user()->education_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->orWhereNull('education_id')
        ->where('category_id', auth()->user()->category_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->with('discount')
        ->get(); // Get bundles that havs the same category of student and student does not buy it
        $student_bundles = $this->bundles
        ->where('category_id', auth()->user()->category_id)
        ->where('education_id', auth()->user()->education_id)
        ->whereHas('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->orWhereNull('education_id')
        ->where('category_id', auth()->user()->category_id)
        ->whereHas('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->with('subjects')
        ->get(); // Get bundles that student buy it with its subjects
        $bundles_subjects = [];
        foreach ($student_bundles as $item) {
            $bundles_subjects = array_merge($bundles_subjects, 
            $item->subjects->pluck('id')->toArray());
        } 
        $subjects = $this->subjects
        ->where('category_id', auth()->user()->category_id)
        ->where('education_id', auth()->user()->education_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->whereNotIn('id', $bundles_subjects)
        ->orWhereNull('education_id')
        ->where('category_id', auth()->user()->category_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->whereNotIn('id', $bundles_subjects)
        ->with('discount')
        ->get(); // Get subject that havs the same category of student and student does not buy it
        $live = $this->live
        ->whereHas('subject', function($query) {
            $query->where('category_id', auth()->user()->category_id);
        })
        ->get(); // Get live that havs the same category of student

        foreach ($subjects as $subject) {
            $lessons = 0;
            // Manually add the count of lessons to each chapter
            foreach ($subject->chapters as $chapter) {
                $lessons += $chapter->lessons()->count();
            }
            // Manually add price after discount
            foreach ($subject->discount as $discount) {
                if ( $discount->type == 'precentage' ) {
                    $subject->price_discount = $subject->price - ($subject->price * $discount->amount / 100);
                } else {
                    $subject->price_discount = $subject->price - $discount->amount;
                }
                break;
            }
            $subject->lesson_count = $lessons;
        }
        foreach ($bundles as $bundle) {
            // Manually add price after discount
            foreach ($bundle->discount as $discount) {
                if ( $discount->type == 'precentage' ) {
                    $bundle->price_discount = $bundle->price - ($bundle->price * $discount->amount / 100);
                } else {
                    $bundle->price_discount = $bundle->price - $discount->amount;
                }
                break;
            }
        }

        return response()->json([
            'bundles' => $bundles,
            'subjects' => $subjects,
            'live' => $live,
        ]);
    }
}
