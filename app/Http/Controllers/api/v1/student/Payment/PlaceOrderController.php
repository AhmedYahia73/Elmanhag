<?php

namespace App\Http\Controllers\api\v1\student\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Student\PlaceOrderRequest;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\bundle;
use App\Models\Live;
use App\Models\subject;
use App\Models\LiveRecorded;
use App\trait\image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupNotificationMail;

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
     private bundle $bundle,
     private Live $live,
     private subject $subject,
     private LiveRecorded $record_live,
     ){}
    // This Is Controller About any Placing Order About Student 
    use image;
    public function place_order( PlaceOrderRequest $request ){
        $old_payments = $this->payment
        ->whereNull('status')
        ->where('student_id', $request->user()->id)
        ->get();
       $newOrder = $request->only($this->orderPlaceReqeust);
       $student_id = $request->user()->id;
        $student = $request->user();
        $affiliate_id = $student->affilate_id;
        $payment_method_id = $request->payment_method_id;
        $bundle_id = $request->bundle_id;
        $subject_id = $request->subject_id;
        $live_id = $request->live_id;
        $record_live_id = $request->record_live_id;
        $payment = $this->paymenty_method->where('id',$payment_method_id)->first();
        $payment_title = $payment->title; 
        $payment_oreder = [];
        $amount = json_decode($newOrder['amount']);

        if ($newOrder['service'] == 'Bundle') {
            $user_bundle_id = json_decode($bundle_id);
            foreach ($old_payments as $item) {
                foreach ($item->bundle as $element) {
                    if (in_array($element->id, $user_bundle_id)) {
                        return response()->json([
                            'faild' => 'You buy bundle before'
                        ], 403);
                    }
                }
            }
       }
       elseif($newOrder['service'] == 'Subject'){
        
            $user_subject_id = json_decode($subject_id);
            foreach ($old_payments as $item) {  
                foreach ($item->subject as $element) {
                    if (in_array($element->id, $user_subject_id)) {
                        return response()->json([
                            'faild' => 'You buy subject before'
                        ], 403);
                    }
                }
             }
       }
    //    $payment_title == 'vodafon cach' ? 
    //    $newOrder['receipt'] = $this->upload($request,'receipt','student/receipt')
    //    : $newOrder['receipt'] = 'default.png';
        $newOrder['amount'] =  collect($amount)->sum();
        $receipt = $this->upload($request,'receipt','student/receipt');
        if (!empty($receipt)) {
            $newOrder['receipt'] = $receipt;
            $payment_oreder['receipt'] =  url('storage/' . $newOrder['receipt']);
        }
       $newOrder['purchase_date']= now();
       $newOrder['student_id']= $student_id ;
        if($payment_title == 'fawry'){
            return response ()->json(['This Method UnAvailable Now']);
        }
                    
            $payment = $this->payment;
          $newOrder = $payment->create($newOrder);
          if($newOrder['service'] == 'Bundle'){
            $bundle_id = json_decode($bundle_id);
            $bundlePayment = $newOrder->bundle()->attach($bundle_id);
            $payment_oreder['order'] = $this->bundle
            ->whereIn('id', $bundle_id)
            ->get();
        }elseif($newOrder['service'] == 'Subject'){
            $subject_id = json_decode($subject_id);
            $bundleSubject = $student->bundles;
                if(is_array($bundleSubject) && count($bundleSubject) > 0){
                    $studentSubject = $bundleSubject[0]->subjects->whereIn('id',$subject_id);
                    $studentSubjectID = $studentSubject->pluck('id')->toArray();
                    $subject_id = array_diff($subject_id,$studentSubjectID);
                }
             $subjectPayment = $newOrder->subject()->attach($subject_id);
            $payment_oreder['order'] = $this->subject
            ->whereIn('id', $subject_id)
            ->get();
        }elseif($newOrder['service'] == 'Live session'){
            $livePayment = $newOrder->live()->attach($live_id);
            $payment_oreder['order'] = $this->live
            ->whereIn('id', $live_id)
            ->get();

        }
        elseif ($newOrder['service'] == 'Recorded live') {
            $payment_oreder['order'] = $this->record_live
            ->whereIn('id', $record_live_id)
            ->get();
        }
        else{
            return response()->json([
                'faield' => 'This Service UnAvailable' ,
            ]);
        }
     

      $subject = "Payment Notification Mail";
      $view = "Payment";
      $payment_oreder['student'] = $request->user()->name;
      $payment_oreder['category'] = $request->user()->category->name;
      $payment_oreder['amount'] = $newOrder->amount;
      $payment_oreder['date'] = $newOrder->purchase_date;
      $payment_oreder['payment_method'] = $payment_title;
       Mail::to('elmanhagedu@gmail.com')->send(new SignupNotificationMail($payment_oreder,$subject,$view));
        return response()->json([
            'success'=>'The request has been sent and is awaiting approval from the Admin'
        ]);
    }
} 
