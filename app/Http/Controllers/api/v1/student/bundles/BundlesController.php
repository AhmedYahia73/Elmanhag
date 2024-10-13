<?php

namespace App\Http\Controllers\api\v1\student\bundles;

use App\GetNexDay;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\bundle;
use App\Models\subject;
use App\Models\Live;
use Illuminate\Support\Facades\Auth;

class BundlesController extends Controller
{
    use GetNexDay;
    public function __construct(private bundle $bundles, private subject $subjects, private Live $live){}
    
    public function show(){
        // https://bdev.elmanhag.shop/student/bundles
        $bundles = $this->bundles
        ->where('category_id', Auth::user()->category_id)
        ->where('education_id', Auth::user()->education_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->orWhereNull('education_id')
        ->where('category_id', Auth::user()->category_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->with('discount')
        ->get(); // Get bundles that havs the same category of student and student does not buy it
        $student_bundles = $this->bundles
        ->where('category_id', Auth::user()->category_id)
        ->where('education_id', Auth::user()->education_id)
        ->whereHas('users', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->orWhereNull('education_id')
        ->where('category_id', Auth::user()->category_id)
        ->whereHas('users', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->with('subjects')
        ->get(); // Get bundles that student buy it with its subjects
        $bundles_subjects = [];
        foreach ($student_bundles as $item) {
            $bundles_subjects = array_merge($bundles_subjects, 
            $item->subjects->pluck('id')->toArray());
        }
        $subjects = $this->subjects
        ->where('category_id', Auth::user()->category_id)
        ->where('education_id', Auth::user()->education_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->whereNotIn('id', $bundles_subjects)
        ->orWhereNull('education_id')
        ->where('category_id', Auth::user()->category_id)
        ->whereDoesntHave('users', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->whereNotIn('id', $bundles_subjects)
        ->with('discount')
        ->get(); // Get subject that havs the same category of student and student does not buy it

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

        $bundles = $bundles->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));
        $subjects = $subjects->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));

        $live = $this->live
        ->where('category_id', Auth::user()->category_id)
        ->where('education_id', Auth::user()->education_id)
        ->whereDoesntHave('students', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->where('inculded', 0)
         
        
        ->orWhereNull('education_id')
        ->where('category_id', Auth::user()->category_id)
        ->whereDoesntHave('students', function ($query) {
            $query->where('users.id', Auth::user()->id);
        })
        ->where('inculded', 0)
         
        ->orWhereNotIn('subject_id', $subjects->pluck('id'))
        ->where('inculded', 1)
        ->where('category_id', Auth::user()->category_id)
        ->where('education_id', Auth::user()->education_id)
        
        ->get(); // Get live that havs the same category of student
        
        foreach ($live as $liveSession) {
            $fixed = $liveSession->fixed;
            if ($fixed == True) {
            $startDate = $liveSession->date; // Get Start Date Session
            $sessionTime = $liveSession->to; // Get Expired Date Session
            $endDate = $liveSession->end_date; // Get Expired Date Session
            $dayOfWeek = $liveSession->day; // Get The Day Session
           $liveSession->timeZoneFixed =  $nexDay = $this->getNextDayBetween($startDate, $endDate, $dayOfWeek,$sessionTime); // Get Next Same Day & Date of Next Week Name
                    $nexDay['name']; // Get Next Same Day of Next Week Name
                    $nexDay['date']; // Get Next Date The Same Date of Next Week
        }
        }
        return response()->json([
            'bundles' => $bundles,
            'subjects' => $subjects,
            'live' =>  $live,
        ]);
    }
}
