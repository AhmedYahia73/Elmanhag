<?php

namespace App\Http\Controllers\api\v1\student\paymentMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function __construct(private PaymentMethod $payment_methods){}

    public function view(){
        // https://bdev.elmanhag.shop/student/paymentMethods
        $payment_methods = $this->payment_methods->get();

        return response()->json([
            'payment_methods' => $payment_methods
        ]);
    }
}
