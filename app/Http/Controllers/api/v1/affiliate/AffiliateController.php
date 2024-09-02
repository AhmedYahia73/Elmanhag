<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\affiliate\AfilliateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    // This Controller About Affiliate
    protected $requestAffiliate = ['name','phone','country','city','password'];
        public function __construct(private User $user){}
    protected $requestAccountAfilliate = ['affilate_id'];
    public function store(AfilliateRequest $request){
        $newAffilate =  $request->only($this->requestAffiliate);
        $user = $this->user ;
        $user->cteate($newAffilate);
        $user->income->create(['affilate_id'=>$user->id]);
    }
}
