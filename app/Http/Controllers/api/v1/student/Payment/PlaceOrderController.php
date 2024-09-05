<?php

namespace App\Http\Controllers\api\v1\student\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\student\PlaceOrderRequest;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;

class PlaceOrderController extends Controller
{
    public function __construct(
        private Payment $payment,
        private User $affiliate,
        private PaymentMethod $paymenty_method,
        ){}
    protected $orderPlaceReqeust = [
         'amount',
         'service',
         'payment_method_id',
         'receipt',
         'bundle_id',
         'status',
    ];
    // This Is Controller About any Placing Order About Student 
    public function place_order( PlaceOrderRequest $request ){

       $newOrder = $request->only($this->orderPlaceReqeust);
        $student = $request->user();
        $affiliate_id = $student->affilate_id;
        $payment_method_id = $request->payment_method_id;
        $payment = $this->paymenty_method->where('id',$payment_method_id);
        $payment_title = $payment->title;
            if($payment_title == 'fawry'){
                        return response ()->json(['This Method UnAvailable Now']);
            }

        $payment = $this->payment;
        $payment->create($newOrder);

        return response()->json([
                                    'success'=>'The request has been sent and is awaiting approval from the Admin'
                                ]);
    }
} 
