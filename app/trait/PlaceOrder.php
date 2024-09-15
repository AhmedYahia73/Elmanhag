<?php

namespace App\trait;

use App\Models\bundle;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

trait PlaceOrder
{

     protected $orderPlaceReqeust =['chargeItems','payment_method_id','merchantRefNum'];
 // This Is Trait About Make any Order 
   

    public function placeOrder(Request $request ){
        $user = $request->user();
        $newOrder = $request->only($this->orderPlaceReqeust);
        $items = $newOrder['chargeItems'];
        // $user_id = $request->user()->id;
        $new_item = [];
        foreach ($items as $item) {
            $itemId = $item['itemId'];
            $service = $item['description'];
            $item_price = $service == 'Bundle' ? 'bundle' : 'subject'; // iF Changed By Sevice Name Get Price One Of Them
            $amount = $this->$item_price->where('id',$itemId)->sum('price'); // Get Price For Item
            $item['student_id'] =$user->id;
            $item['purchase_date'] =now(); // Purchase Date Now
            $item['merchantRefNum'] =$newOrder['merchantRefNum']; // This Is Reference Number For Order ID 
            $item['service'] =$service ; // This Is Reference Number For Order ID
            try {
                $paymentMethod = $this->paymenty_method->where('title','fawry')->first();
            } catch (QueryException $qe) {
                return response()->json([
                    'faield'=>'payment Method Don\'t Available',
                    'message'=>$qe->getMessage()
                ]);
            }
            $item['payment_method_id'] =$paymentMethod->id; // This Payment Static casue Don't Have Name Request In Item Charge
            $item['price'] = $amount ; // Price Take Amount Cause I Have just One Item
            $item['amount']=$amount;
            $createPayment = $this->payment->create($item);
            if($service == 'Bundle'){
                $newbundle = $createPayment->bundle()->sync($itemId);
              }elseif($service == 'Subject'){
                $newSubjects = $createPayment->subject()->sync($itemId);
              }
               $order = [ // This Is Data Returned For Payment Request
               'chargeItems'=> $items
               ];
            }
                  return $order;
    }
}
