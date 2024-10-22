<?php

namespace App\Http\Controllers\api\v1\admin\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\User;
use App\Models\AffilateAccount;
use App\Models\AffilateHistory;
use App\Models\AffilateCommession;
use App\Models\Bonus;

class PaymentController extends Controller
{
    public function __construct(private Payment $payments, private User $user,
    private AffilateAccount $affilate_account, private AffilateHistory $affilate_history,
    private AffilateCommession $affilate_commession, private Bonus $bonus){}
    
    public function pendding_payment(){
        // https://bdev.elmanhag.shop/admin/payment/pendding
        $payments = $this->payments
        ->where('status', null)
        ->with(['student.category', 'payment_method', 'bundle', 'subject', 'live'])
        ->get();

        return response()->json([
            'payments' => $payments
        ]);
    }

    public function rejected_payment( Request $request, $id ){
        // https://bdev.elmanhag.shop/admin/payment/pendding/rejected/{id}
        // key
        // rejected_reason
        $this->payments
        ->where('id', $id)
        ->update([
            'status' => 0,
            'rejected_reason' => $request->rejected_reason
        ]);// Update Payment to rejected with update reasons

        return response()->json([
            'success' => 'You reject data success'
        ]);
    }

    public function approve_payment($id){
        // https://bdev.elmanhag.shop/admin/payment/pendding/approve/1
        $payment = $this->payments
        ->where('id', $id)
        ->where('status', null) 
        ->orWhere('id', $id)
        ->where('status', 0) 
        ->with(['bundle', 'subject'])
        ->first(); // Get payment with its service [bundles, subjects]
        
        if (empty($payment)) {
            
            return response()->json([
                'faild' => 'You approve this payment at last or this payment does not found'
            ]);
        }
        $user = $this->user
        ->where('id', $payment->student_id)
        ->first(); // Get User To Add Service to him
        $first_payment = $this->payments
        ->where('student_id', $payment->student_id)
        ->where('status', 1)
        ->first(); // Get first payment for student
        $service_type = null;

        // Determine Service That User Pay it
        if ( $payment->service == 'Subject' ) {
            $subjects = $payment->subject->pluck('id')->toArray(); // Get subjects as array
            if (count($subjects) > 0) {
                $user->subjects()->attach($subjects); // Add subjects to student
            }
            $service_type = 'subject';
        }
        elseif ( $payment->service == 'Bundle' ) {
            $bundles = $payment->bundle->pluck('id')->toArray(); // Get bundles as array
            if (count($bundles) > 0) {
                $user->bundles()->attach($bundles); // Add bundles to student
            }
            $service_type = 'bundle';
        }
        elseif ( $payment->service == 'Live session' ) {
            $lives = $payment->live->pluck('id')->toArray(); // Get lives as array
            if (count($lives) > 0) {
                $user->live()->attach($lives); // Add bundles to student
            }
            $service_type = 'live_session';
        }
        elseif ( $payment->service == 'Live Package' ) {
            // code
            $service_type = 'live_bundle';
        }
        elseif ( $payment->service == 'Revision' ) {
            // code
            $service_type = 'revision';
        }
        
        //if student has affilate and it is the first payment for him
       if (!empty($user->affilate_id) && $user->affilate_id  != null && empty($first_payment)) {
           $affilate_account = $this->affilate_account
           ->where('affilate_id', $user->affilate_id)
           ->first();
           $commesion = $this->affilate_commession->first();
           $affilate_commession = $commesion->type == 'fixed' ? $commesion->amount :
           $payment->amount	* $commesion->amount / 100;
           if (!empty($affilate_account)) {
                $affilate_account->update([
                    'income' => $affilate_account->income + $affilate_commession,
                    'wallet' => $affilate_account->wallet + $affilate_commession,
                ]); // Add commession to income and wallet
           }
           else{
                $affilate_account->create([
                    'income' => $affilate_account->income + $affilate_commession,
                    'wallet' => $affilate_account->wallet + $affilate_commession,
                    'affilate_id' => $user->affilate_id,
                ]); // create affilate account if not found
           }
           $affilate_history = $this->affilate_history
           ->create([
            'date' => $payment->created_at,
            'service' => $service_type,
            'service_type' => $service_type,
            'price' => $payment->amount,
            'commission' => $affilate_commession,
            'student_id' => $payment->student_id,
            'category_id' => $user->category_id,
            'payment_method_id' => $payment->payment_method_id ,
            'affilate_id' => $user->affilate_id,
           ]); // Make affilate history

           // if service bundle it check target of bonus
           if ($service_type == 'bundle') {
                $affilate_history = $this->affilate_history
                ->where('service_type', 'bundle')
                ->where('affilate_id', $user->affilate_id)
                ->count();
                $bonus = $this->bonus
                ->where('target', $affilate_history)
                ->first(); // Give bones When achive target
                if (!empty($bonus)) { // if bonus does not empty
                    if (intval($bonus->bonus)) {
                        $affilate_account = $this->affilate_account
                        ->where('affilate_id', $user->affilate_id)
                        ->first();
                        $affilate_account->update([
                            'income' => $affilate_account->income + $bonus->bonus,
                            'wallet' => $affilate_account->wallet + $bonus->bonus,
                        ]); // Add bonus to income and wallet
                    }

                    $bonus->affilate()->attach($user->affilate_id);
                }
           }
       }

        $payment->update([
            'status' => 1
        ]); // Update Payment to approve

        return response()->json([
            'success' => 'You Approve Payment Success'
        ]);
    }

    // function that return approve payment
    public function payments(){
        // https://bdev.elmanhag.shop/admin/payment
        $payments = $this->payments
        ->where('status', 1)
        ->with(['student.category', 'payment_method', 'bundle', 'subject'])
        ->get(); // Get approve payment

        return response()->json([
            'payments' => $payments
        ]);
    }
}
