<?php

namespace App\trait;

use App\Models\bundle;
use App\Models\subject;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use DragonCode\Contracts\Cashier\Config\Payments\Statuses;
use Error;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupNotificationMail;

trait PlaceOrder
{

     protected $orderPlaceReqeust =['chargeItems','amount','customerProfileId','payment_method_id','merchantRefNum'];
 // This Is Trait About Make any Order 
   

    public function placeOrder(Request $request ){
        
        $user = $request->user();
         $newOrder = $request->only($this->orderPlaceReqeust);
        $items = $newOrder['chargeItems'];
        
        // $user_id = $request->user()->id;
        $new_item = [];
        $service = $newOrder['chargeItems'][0]['description'];
        $amount = $newOrder['amount'];
         $paymentMethod = $this->paymenty_method->where('title','fawry')->first();
        $payment_method_id = $paymentMethod->id;
                    if(!$paymentMethod){
                        return abort(404);
                    }
         $paymentData = [
               "merchantRefNum"=> $newOrder['merchantRefNum'],
               "student_id"=> $newOrder['customerProfileId'],
               "amount"=> $newOrder['amount'],
               "service"=> $service,
               "purchase_date"=>now(),
               "payment_method_id"=>$payment_method_id,
               "receipt"=>'fawry.png',
        ];
     
            
                   $createPayment = $this->payment->create($paymentData);
        foreach ($items as $item) {
                
            $itemId = $item['itemId'];
            $item_type = $service == 'Bundle' ? 'bundle' : 'subject'; // iF Changed By Sevice Name Get Price One Of Them
            
            try {
             $payment_number = $createPayment->id;
            if($service == 'Bundle'){
                $newbundle = $createPayment->bundle()->sync($itemId);            
                $payment_oreder['order'] = $this->bundle
                ->whereIn('id', $itemId)
                ->get();
              }elseif($service == 'Subject'){
                  $subject_id = json_decode($item['itemId']);
                  $bundleSubject = $user->bundles;
                  if(is_array($bundleSubject) && count($bundleSubject) > 0){
                            $studentSubject = $bundleSubject[0]->subjects->whereIn('id',$subject_id);
                            $studentSubjectID = $studentSubject->pluck('id')->toArray();
                            $subject_id = array_diff($subject_id,$studentSubjectID);
                  }
                $newSubjects = $createPayment->subject()->attach($subject_id);   
                $payment_oreder['order'] = $this->subject
                ->whereIn('id', $subject_id)
                ->get();
              }elseif($service == 'Live session'){
                    $live_id = $item['itemId'];
                      $newLive = $createPayment->live()->attach($live_id);
                      $payment_oreder['order'] = $this->live
                       ->where('id', $live_id)
                       ->get();
              }elseif($service == 'Recorded live'){
                    $record_live_id = $item['itemId'];
                     $recordedLivePayment = $createPayment->recorded_live()->attach($record_live_id);
                     $payment_oreder['order'] = $this->liveRecorded
                     ->where('id', $record_live_id)
                     ->get();
              }
              } catch (\Throwable $th) {
               return abort(code: 500);
              }
            $data = [
                'paymentProcess' => $payment_number,
                    'chargeItems'=>[
                        'itemId'=>$subject_id[0] ?? $itemId,
                        'description'=>$item_type,
                        'price'=>$amount,
                        'quantity'=>'1',
                    ]
            ];
              
            }
      $subject = "Payment Notification Mail";
      $view = "Payment";
      $payment_oreder['receipt'] = null;
      $payment_oreder['student'] = $request->user()->name;
      $payment_oreder['category'] = $request->user()->category->name;
      $payment_oreder['amount'] = $newOrder['amount'];
      $payment_oreder['date'] = $request->purchase_date;
      $payment_oreder['payment_method'] = 'fawry';
       Mail::to('elmanhagedu@gmail.com')->send(new SignupNotificationMail($payment_oreder,$subject,$view));
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
