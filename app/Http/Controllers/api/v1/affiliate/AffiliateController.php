<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\admin\affilate\AffilateRequest;
use App\Http\Requests\api\affiliate\AfilliateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    // This Controller About Affiliate
    protected $requestAffiliate = ['name','email','phone','role','country_id','city_id','password'];
        public function __construct(private User $user){}
    protected $requestAccountAfilliate = ['affilate_id'];
    public function store(AfilliateRequest $request){
        $newAffilate =  $request->only($this->requestAffiliate);
        $newAffilate['role'] ='affilate';
        $user = $this->user ;
        $user = $user->create($newAffilate);
        $newAffilate['image'] = 'default.png';
        $affiliate =['affilate_id'=> $user->id];
        $user->income()->create($affiliate);
        $token = $user->createToken('personal access token')->plainTextToken; // Start Create Token
        $user->token = $token; // Start User Take This Token ;
        $user->image = 'default.png'; // Start User Take This Token ;
        return response()->json([
            'success'=>'affilate Add Successfully',
            '_tokent'=>$token,
            'user' => $user],200);
    }



}
