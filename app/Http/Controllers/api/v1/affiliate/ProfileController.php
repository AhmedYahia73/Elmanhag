<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\trait\image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

        protected $requestProfile = ['name','email','phone','role','country','city','password'];
         /**
         * Class constructor.
         * Affiliate Profile
         */
        public function __construct(private User $user){}
    // This Is About Affiliate Profile
    use image;
    public function show(Request $request){
                try {
                         $user = $request->user();
                         $income = $user->income;
                         $payout = $user->payout_history;
                         $affiliate_history = $user->affiliate_history;
                         $total_payout = $user->payout_history->where('status','1')->sum('amount');
                } catch (QueryException $th) {
            return response()->json([
                'message'=>'Something Wrong',
                'error'=>$th->getMessage(),
            ]);
                }

        return response()->json([
            'success'=>'data Returned Successfully',
            'user'=>$user,
            'total_payout'=>$total_payout,
        ]);
    }

     public function modify(Request $request){
        $user_id = $request->user()->id;
        $user = $this->user::findOrFail($user_id);
         $updateProfile = $request->only($this->requestProfile);
                $user->name = $updateProfile['name'] ?? $user->name;
                $user->email = $updateProfile['email'] ?? $user->email ;
                    if( isset($updateProfile['password'])){
                        $user->password = $updateProfile['password'] ;
                    }
                     $this->deleteImage($user->image);
                $user->phone = $updateProfile['phone'] ?? $user->phone ;
                $user->role = 'affilate';
                $image_path = $this->upload($request, 'image', 'affilate/users');
                $user->image = $image_path ?? $user->image;
                $user->city_id = $updateProfile['city_id']?? $user->city_id;
                $user->country_id = $updateProfile['country_id']?? $user->country_id;
                $user->save();
                        return response()->json([
                            'success'=>'Data Updated Successfully',
                            ]);

     }
}   




           
