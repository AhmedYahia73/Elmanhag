<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PaymentMethod;

class PaymentMethodsController extends Controller
{
    public function __construct(private PaymentMethod $payment_methods){}
    public function show(){
        $payment_methods = $this->payment_methods->get();

        return response()->json([
            'payment_methods' => $payment_methods
        ]);
    }

    public function create(){

    }

    public function modify(){

    }

    public function delete($id){

    }
}
