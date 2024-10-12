<?php

namespace App\Http\Controllers\api\v1\student\promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\Student\promocode\PromoCodeRequest;

use App\Models\PromoCode;
use App\Models\subject;

class PromoCodeController extends Controller
{
    public function __construct(private PromoCode $promo_code, private subject $subject){}

    public function promo_code(PromoCodeRequest $request){
        // https://bdev.elmanhag.shop/student/promoCode
        // Keys
        // type[bundle,subject,live], id, code, price
        $promo_code = $this->promo_code
        ->where('status', 1)
        ->whereColumn('usage', '>', 'number_users')
        ->where('code', $request->code)
        ->orWhere('usage_type', 'unlimited')
        ->where('status', 1)
        ->where('code', $request->code)
        ->orderByDesc('id')
        ->first();
        $price_fixed = 0;

        if (!empty($promo_code)) {
            if ($request->type == 'Bundle') {
                $ids = json_decode($request->id);
                $promo_code_state = $promo_code->bundles->whereIn('id', $ids)->toArray();
            }
            elseif ($request->type == 'Subject') {
                $ids = json_decode($request->id);
                $subject_price = $request->price;
                $subject_promo = $promo_code->subjects->whereIn('id', $ids);
                $request->price = $subject_promo->sum('price');
                $promo_code_state = $subject_promo->toArray();
            }
            elseif ($request->type == 'Live') {
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
        
        if ((is_array($promo_code_state) && count($promo_code_state) != 0) || (is_numeric($promo_code_state) && $promo_code_state == 1)) {
            $price = $request->price;
            if (!empty($promo_code->value)) {
                $price = $request->price - $promo_code->value;
            }
            elseif (!empty($promo_code->precentage)) {
                $price = $request->price - $request->price * $promo_code->precentage / 100;
            }
            $promo_code->update(['number_users' => $promo_code->number_users + 1]);
            $price += $price_fixed;
            
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
