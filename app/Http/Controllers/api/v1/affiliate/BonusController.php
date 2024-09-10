<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\User;
use Composer\Semver\Constraint\Bound;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    // This Is Controller About All Affiliate Bonus

    public function __construct(private User $affilateBonus,private Bonus $bound){}

    public function get_bonus(Request $request){
        $user_id = $request->user()->id;
         $user = $request->user()->where('id',$user_id)->with('bonuses',function($query){
            $query->orderByDesc('id');
         })->first();
        $bonus = $user->bonuses->unique()->first();
       $bonus->bundle_paid = $user->affiliate_history->where('service_type','bundle')->count();
        $bonus->total_bonus = $this->bound->get();
        // $targetBonus = $user->targetBonus->first();

        return response()->json([
            'success'=>'Bonus Returned Successfully',
            'affiliate_bonus'=>$bonus,
        ]);
    }
}
