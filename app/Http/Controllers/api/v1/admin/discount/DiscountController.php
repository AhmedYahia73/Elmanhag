<?php

namespace App\Http\Controllers\api\v1\admin\discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Discount;

class DiscountController extends Controller
{
    public function __construct(private Discount $discount){}
    public function show(){
        $discounts = $this->discount
        ->with(['category', 'subject', 'bundle'])
        ->get();
        foreach ($discounts as $item) {
            if ( !empty($item->subject) ) {
                $item->subject_price = $item->subject->price;
                if ( $item->type == 'value' ) {
                    $item->subject_price_discount = $item->subject->price - $item->amount;
                } else {
                    $item->subject_price_discount = $item->subject->price - ($item->subject->price * $item->amount / 100);
                }
            }
            if ( !empty($item->bundle) ) {
                $item->bundle_price = $item->bundle->price;
                if ( $item->type == 'value' ) {
                    $item->bundle_price_discount = $item->bundle->price - $item->amount;
                } else {
                    $item->bundle_price_discount = $item->bundle->price - ($item->bundle->price * $item->amount / 100);
                }
            }
        }

        return response()->json([
            'discounts' => $discounts
        ]);
    }
}
