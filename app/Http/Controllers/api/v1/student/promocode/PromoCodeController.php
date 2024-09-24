<?php

namespace App\Http\Controllers\api\v1\student\promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\Student\promocode\PromoCodeRequest;

use App\Models\PromoCode;

class PromoCodeController extends Controller
{
    public function __construct(private PromoCode $promo_code){}

    public function promo_code(PromoCodeRequest $request){
        $promo_code = $this->promo_code
        ->where('status', 1)
        ->whereColumn('usage', '>', 'number_users')
        ->where('code', $request->code)
        ->orWhere('usage_type', 'unlimited')
        ->where('status', 1)
        ->where('code', $request->code)
        ->orderByDesc('id')
        ->first();

        if (!empty($promo_code)) {
            if ($request->type == 'bundle') {
                # code...
            }
            elseif ($request->type == 'subject') {
                # code...
            }
            elseif ($request->type == 'live') {
                # code...
            }
        } else {
            return response()->json([
                'faild' => 'This promoCode is expired'
            ]);
        }
        
    }
}
