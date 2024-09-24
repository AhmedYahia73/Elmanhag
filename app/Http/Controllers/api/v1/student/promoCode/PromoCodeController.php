<?php

namespace App\Http\Controllers\api\v1\student\promoCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\student\promoCode\PromoCodeRequest;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    // This Controller Abot PromoCode When Get any Offer About Bundle or Subject or Live Session

     public function __construct() {}

     public function promo_code(PromoCodeRequest $request){
        $code = $request->promoCode;        
     }
}
