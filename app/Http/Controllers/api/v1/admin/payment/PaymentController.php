<?php

namespace App\Http\Controllers\api\v1\admin\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;

class PaymentController extends Controller
{
    public function __construct(private Payment $payments){}
    
    public function pendding_payment(){
        $payments = $this->payments
        ->where('status', null)
        ->with(['student', 'payment_method', 'bundle', 'subject'])
        ->get();

        return response()->json([
            'payments' => $payments
        ]);
    }
}
