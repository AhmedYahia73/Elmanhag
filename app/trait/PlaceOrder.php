<?php

namespace App\trait;

use App\Models\bundle;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use DragonCode\Contracts\Cashier\Config\Payments\Statuses;
use Error;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
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

       
         $paymentMethod = $this->paymenty_method->where('title','fawry')->first();
     
            if(empty($paymentMethod)){
                    return abort(404);
            }
                    
        foreach ($items as $item) {
            $itemId = $item['itemId'];
            $service = $item['description'];
            $item_type = $service == 'Bundle' ? 'bundle' : 'subject'; // iF Changed By Sevice Name Get Price One Of Them
            
            try {
             $amount = $this->$item_type->where('id',$itemId)->sum('price'); // Get Price For Item
           
            $item['student_id'] =$user->id;
            $item['purchase_date'] =now(); // Purchase Date Now
            $item['merchantRefNum'] =$newOrder['merchantRefNum']; // This Is Reference Number For Order ID
            $item['service'] =$service ; // This Is Reference Number For Order ID
         
           

            $item['payment_method_id'] =$paymentMethod->id; // This Payment Static casue Don't Have Name Request In Item Charge
            $item['price'] = $amount ; // Price Take Amount Cause I Have just One Item
            $item['amount']=$amount;
            $createPayment = $this->payment->create($item);
            $payment_number = $createPayment->id;
            if($service == 'Bundle'){
                $newbundle = $createPayment->bundle()->sync($itemId);
              }elseif($service == 'Subject'){
                $newSubjects = $createPayment->subject()->sync($itemId);
              }
              } catch (\Throwable $th) {
               return abort(code: 500);
              }
            $data = [
                
                'paymentProcess' => $payment_number,
                    'chargeItems'=>[
                        'itemId'=>$itemId,
                        'description'=>$item_type,
                        'price'=>$amount,
                        'quantity'=>'1',
                    ]
            ];
              
            }
                  return $data ;
    }

    public function confirmOrder($response){
        if(isset($response['code']) && $response['code'] == 9901){
                return response()->json($response);
            }elseif(!isset($response['merchantRefNum'])){
                       $response =  response()->json(['faield'=>'Merchant Reference Number Not Found'],404);
                        return $response;
                    }else{
                  $merchantRefNum = $response['merchantRefNum'];
                  $customerMerchantId = $response['customerMerchantId'];
                  $orderStatus = $response['orderStatus'];
            }
  
            if($orderStatus == 'PAID'){
            $payment =
                $this->payment->where('merchantRefNum', $merchantRefNum)->with('bundle', function ($query):void {
                    $query->with('users');
                }, 'subject', function ($query):void {
                    $query->with('users');
           })->first();
            $order = $payment->service == 'Bundle' ? 'bundle' : 'subject';
            if($order == 'bundle'){
                $orderBundle = $payment->bundle;
                foreach($orderBundle as $student_bundle){
                     $student_bundle->users()->attach([$student_bundle->id=>['user_id'=>$customerMerchantId]] );
                }
            }elseif($order == 'subject'){
                $orderSubject= $payment->subject;
                 foreach($orderSubject as $student_subject){
                  $student_subject->users()->attach([$student_subject->id=>['user_id'=>$customerMerchantId]] );
                 }
            }

        }
        return response()->json($response);
    }
}
