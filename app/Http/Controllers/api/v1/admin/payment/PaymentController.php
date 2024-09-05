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
        ->with(['student', 'payment_method', 'bundle', 'subject'])
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
        ->with(['bundle', 'subject'])
        ->first(); // Get payment with its service [bundles, subjects]
        $user = $this->user
        ->where('id', $payment->student_id)
        ->first(); // Get User To Add Service to him
        $first_payment = $this->payments
        ->where('student_id', $payment->student_id)
        ->first(); // Get first payment for student
        $service_type = null;

        // Determine Service That User Pay it
        if ( $payment->service == 'Subject' ) {
            $subjects = $payment->subject->pluck('id')->toArray(); // Get subjects as array
            $user->subjects()->sync($subjects); // Add subjects to student
            $service_type = 'subject';
        }
        elseif ( $payment->service == 'Bundle' ) {
            $bundles = $payment->bundle->pluck('id')->toArray(); // Get bundles as array
            $user->bundles()->sync($bundles); // Add bundles to student
            $service_type = 'bundle';
        }
        elseif ( $payment->service == 'Live session' ) {
            // code
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
       if (!empty($user->affilate_id) && $user->affilate_id  != null && $first_payment->id == $payment->id) {
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
                ]);
           }
           else{
                $affilate_account->create([
                    'income' => $affilate_account->income + $affilate_commession,
                    'wallet' => $affilate_account->wallet + $affilate_commession,
                    'affilate_id' => $user->affilate_id,
                ]);
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
        ->with(['student', 'payment_method', 'bundle', 'subject'])
        ->get(); // Get approve payment

        return response()->json([
            'payments' => $payments
        ]);
    }
}
