<?php

namespace App\Http\Controllers\api\v1\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //


        public function show(Request $request):JsonResponse{
        $user = $request->user();
        return response()->json([
            'success'=>'data returned Successfully',
            'user'=>$user,
        ],200);
        }
}
