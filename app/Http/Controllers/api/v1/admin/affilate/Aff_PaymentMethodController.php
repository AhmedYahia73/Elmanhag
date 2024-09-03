<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\PaymentMethodAffilate;

class Aff_PaymentMethodController extends Controller
{
    public function __construct(private PaymentMethodAffilate $payment_method){}
    protected $paymentMethodRequest = [
        'method',
        'min_payout',
    ];

    public function affilate_method(){
        $payment_methods = $this->payment_method
        ->get();

        return response()->json([
            'payment_methods' => $payment_methods
        ]);
    }

    public function affilate_method_add(Request $request){
        $validator = Validator::make($request->all(), [
            'method' => 'required',
            'min_payout' => 'required|numeric'
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $data = $request->only($this->paymentMethodRequest);
        $payment_methods = $this->payment_method
        ->create($data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function affilate_method_update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'method' => 'required',
            'min_payout' => 'required|numeric'
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $data = $request->only($this->paymentMethodRequest);
        $payment_methods = $this->payment_method
        ->where('id', $id)
        ->update($data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
}
