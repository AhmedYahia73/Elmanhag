<?php

namespace App\Http\Controllers\api\v1\admin\promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PromoCode;

class PromocodeController extends Controller
{
    public function __construct(private PromoCode $promo_code){}
    
    public function show(){

    }
}
