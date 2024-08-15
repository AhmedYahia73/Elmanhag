<?php

namespace App\Http\Controllers\api\v1\student\setting;

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
        $user_id = $request->user()->id;
        $user =  $request
            ->user()
            ->where('id', $user_id)
            ->with('category')->first();
        $category = $user->category;
        $category_id = $user->category->id;
       $education_id = $request->education_id;
        try {
            if ($education_id) {
                $subject = $this->subject
                ->orderBy('name')
                ->where('category_id', $category_id)
                ->where('education_id', $education_id)->get();
            } else {
                $subject = $this->subject
                ->where('category_id', $category_id)
                ->orderBy('name')
                ->get();
            }
            return response()->json([
                'success' => 'Data Returned Successfully',
                'category' => $category ,
                'subject' => $subject ,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'faield' => 'Data Not Found',
                'data' => $e->getMessage(),
            ]);
        }
    }
}
