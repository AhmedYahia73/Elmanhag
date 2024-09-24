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
                $promo_code_state = $promo_code->bundles->where('id', $request->id);
            }
            elseif ($request->type == 'subject') {
                $promo_code_state = $promo_code->subjects->where('id', $request->id);
            }
            elseif ($request->type == 'live') {
                if ($promo_code->live) {
                    $promo_code_state = 1;
                } else {
                    $promo_code_state = 0;
                }
                
            }
        } else {
            return response()->json([
                'faild' => 'This promoCode is expired'
            ], 400);
        }

        if ((!empty($promo_code_state) && $promo_code_state != 0) || $promo_code_state == 1) {
            $price = $request->price;
            if (!empty($promo_code->value)) {
                $price = $request->price - $promo_code->value;
            }
            elseif (!empty($promo_code->precentage)) {
                $price = $request->price - $request->price * $promo_code->precentage / 100;
            }

            return response()->json([
                'price' => $price
            ], 200);
        }
        else{
            return response()->json([
                'faild' => 'promo code does not support this service'
            ], 400);
        }
        
        // if promocode have value or h
    }
}
