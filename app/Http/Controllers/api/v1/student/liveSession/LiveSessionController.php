<?php

namespace App\Http\Controllers\api\v1\student\liveSession;

use App\GetNexDay;
use App\Http\Controllers\Controller;
use App\Models\Live;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    // feat => This About Get All Live Sessions For Student
    use GetNexDay;
    public function  __construct(private Live $live) {}
    public function show(Request $request)
    {
        $user = $request->user();
        $user_category = $request->user()->category_id; // Get Student Category
        $user_education = $request->user()->education_id; // Get Student Education
        $session_id = $request->session_id;
        $getLiveSession = $this->live->where('id', $session_id)->first();
        $fixed = $getLiveSession->fixed;
        $now = Carbon::now()->format('Y-m-d');
        $student = $user->where('id', $user->id)->with('bundles.subjects')->with('subjects')
            ->first();

        $bundles = $student->bundles;
        $subject_list = collect();
        foreach ($bundles as $bundle) {
            $bundle_subjec =  $bundle->subjects->pluck('id');
            $subject_list = $subject_list->merge($bundle_subjec);
            $subjects_id = $student->subjects->pluck('id');
            $subject_list = $subject_list->merge($subjects_id);
        }
        if (count($bundles) <= 0) {
            $subjects_id = $student->subjects->pluck('id');
            $subject_list = $subject_list->merge($subjects_id);
        }

        $live = $this->live
            ->where('date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where('inculded', True)
            ->whereIn('subject_id', $subject_list);

        if ($fixed == True) {
            $startDate = $getLiveSession->date; // Get Start Date Session
            $sessionTime =  Carbon::parse($getLiveSession->to);; // Get Expired Date Session
             $sessionTime;
            $endDate = $getLiveSession->end_date; // Get Expired Date Session
            $dayOfWeek = $getLiveSession->day; // Get The Day Session
           return  $nexDay = $this->getNextDayBetween($startDate, $endDate, $dayOfWeek,$sessionTime); // Get Next Same Day & Date of Next Week Name
                    $nexDay['name']; // Get Next Same Day of Next Week Name
                    $nexDay['date']; // Get Next Date The Same Date of Next Week
        }




        $sessions = $live->first();

        return response()->json(
            data: [
                'success' => 'data returned successfully',
                'liveSession' => $sessions,
            ],
            status: 200
        );
    }
}
