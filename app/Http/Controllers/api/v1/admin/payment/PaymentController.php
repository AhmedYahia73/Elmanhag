<?php

namespace App\Http\Controllers\api\v1\admin\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\User;

class PaymentController extends Controller
{
    public function __construct(private Payment $payments, private User $user){}
    
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
        $payment = $this->payments
        ->where('id', $id)
        ->with(['bundle', 'subject'])
        ->first(); // Get payment with its service [bundles, subjects]
        $user = $this->user
        ->where('id', $payment->student_id)
        ->first(); // Get User To Add Service to him

        // Determine Service That User Pay it
        if ( $payment->service == 'Subject' ) {
            $subjects = $payment->subject->pluck('id')->toArray(); // Get subjects as array
            $user->subjects()->sync($subjects); // Add subjects to student
        }
        elseif ( $payment->service == 'Bundle' ) {
            $bundles = $payment->bundle->pluck('id')->toArray(); // Get bundles as array
            $user->bundles()->sync($bundles); // Add bundles to student
        }
        elseif ( $payment->service == 'Live session' ) {
            // code
        }
        elseif ( $payment->service == 'Live Package' ) {
            // code
        }
        elseif ( $payment->service == 'Revision' ) {
            // code
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
        $payments = $this->payments
        ->where('status', 1)
        ->with(['student', 'payment_method', 'bundle', 'subject'])
        ->get(); // Get approve payment

        return response()->json([
            'payments' => $payments
        ]);
    }
}
