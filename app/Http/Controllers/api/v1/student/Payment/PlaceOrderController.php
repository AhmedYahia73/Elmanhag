<?php

namespace App\Http\Controllers\api\v1\student\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\student\PlaceOrderRequest;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use App\trait\image;
use Illuminate\Http\Request;

class PlaceOrderController extends Controller
{
   
    protected $orderPlaceReqeust = [
         'amount',
         'service',
         'payment_method_id',
         'receipt',
         'bundle_id',
         'status',
         'purchase_date',
         'student_id',
    ];

     public function __construct(
     private Payment $payment,
     private User $affiliate,
     private PaymentMethod $paymenty_method,
     ){}
    // This Is Controller About any Placing Order About Student 
    use image;
    public function place_order( PlaceOrderRequest $request ){
        
       $newOrder = $request->only($this->orderPlaceReqeust);
        $student_id = $request->user()->id;
        $student = $request->user();
        $affiliate_id = $student->affilate_id;
        $payment_method_id = $request->payment_method_id;
        $payment = $this->paymenty_method->where('id',$payment_method_id)->first();
        $payment_title = $payment->title;
       $payment_title == 'vodafon cach' ? 
       $newOrder['receipt'] = $this->upload($request,'receipt','student/receipt')
       : $newOrder['receipt'] = 'default.png';
       $newOrder['purchase_date']= now();
       $newOrder['student_id']= $student_id ;
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
