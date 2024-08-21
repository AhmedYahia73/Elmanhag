<?php

namespace App\Http\Controllers\api\v1\student\subject;

use App\Http\Controllers\Controller;
use App\Models\subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{

    public function __construct(
        private subject $subject
    ) {}
    //This Controller About All Subject

    public function show(Request $request)
    {
        $category_id = $request->category_id;
        $education_id = $request->education_id;
        $subject = $this->subject;
        try {
            if ($category_id && $education_id) {
                $subject =  $subject->orderBy('name')
                    ->where('category_id', $category_id)
                    ->where('education_id', $education_id);
            } elseif ($category_id) {
                $subject = $subject->orderBy('name')
                    ->where('category_id', $category_id);
            } elseif ($education_id) {
                $subject = $subject->where('education_id', $education_id)
                    ->orderBy('name');
            }
            $subject = $subject->get();
            return response()->json([
                'success' => 'Data Returned Successfully',
                'subject' => $subject,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'faield' => 'Data Not Found',
                'data' => $e->getMessage(),
            ]);
        }
    }


    public function student_subject(Request $request)
    {
        $user = $request->user();
        $user_id = $user->id;
        try {
            $subject = $user->where('id',$user_id)
            ->with('subjects')
            ->get();
        } catch (QueryException $queryException) {
            return response()->json([
                'faield' => 'Not Found Subject',
                'error' => $queryException,
            ]);
        }

        return response()->json([
            'success' => 'data return Successfully',
            'subject' => $subject,
        ]);
    }
}
