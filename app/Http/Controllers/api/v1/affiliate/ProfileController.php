<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
         /**
         * Class constructor.
         * Affiliate Profile
         */
        public function __construct(private User $user){}
    // This Is About Affiliate Profile

    public function show(Request $request){
                try {
                         $user = $request->user();
                         $income = $user->income;
                         $payout = $user->payout_history;
                } catch (QueryException $th) {
            return response()->json([
                'message'=>'Something Wrong',
                'error'=>$th->getMessage(),
            ]);
                }

        return response()->json([
            'success'=>'data Returned Successfully',
            'user'=>$user,
        ]);
    }
}   
