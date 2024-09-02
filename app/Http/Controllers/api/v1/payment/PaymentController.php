<?php

namespace App\Http\Controllers\api\v1\payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\payment\PaymentReqeust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // This Controller About Payment Fawry

    protected $payment = [
         'merchantCode',
         'merchantRefNum',
         'customerProfileId',
         'paymentMethod',
         'cardNumber',
         'cardExpiryYear',
         'cardExpiryMonth',
         'cvv',
         'customerName',
         'customerMobile',
         'customerEmail',
         'amount',
         'description',
         'language',
         'chargeItems',
         'currencyCode',
         'signature',
         'itemId',
         'description',
         'price',
         'quantity',
    ]; 
    public function payment(PaymentReqeust $request){
        $requestPayment =  $request->only($this->payment);
//    $items  = $requestPayment['chargeItems'];

      response()->json($requestPayment);
 $response = Http::post('https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge', $requestPayment);
        return $response->body();

       
    }
}
