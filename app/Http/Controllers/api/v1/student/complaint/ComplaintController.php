<?php

namespace App\Http\Controllers\api\v1\student\complaint;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    // This Is Controller About Any Complaint From Student
        public function __construct(private Complaint $complaint){}

    protected $requestComplaint = [
        'complaint',
        'user_id',
    ];
    public function store(Request $request ):JsonResponse{
        $newCompaint = $request->only($this->requestComplaint);
        $user_id = $request->user()->id;
        $newCompaint['user_id'] = $user_id; // attibute user_id Get Auth User id
           $validator = Validator::make($request->all(), [
           'complaint' => 'required',
           ]);
           if ($validator->fails()) { // if Validate Make Error Return Message Error
           return response()->json([
           'error' => $validator->errors(),
           ],400);
           }
        $complaint = $this->complaint;
        try {
            $complaint->create($newCompaint);
                    return response()->json(['success'=>'Your Complaint'],200);
        } catch (QueryException $th) {
                    return response()->json(['faield'=>'Something Wrong'],500);
                }
    }
}
