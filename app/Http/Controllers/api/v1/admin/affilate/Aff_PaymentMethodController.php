<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\PaymentMethodAffilate;

class Aff_PaymentMethodController extends Controller
{
    public function __construct(private PaymentMethodAffilate $payment_method){}
    protected $paymentMethodRequest = [
        'method',
        'min_payout',
        'status'
    ];
    use image;

    public function affilate_method(){
        // https://bdev.elmanhag.shop/admin/affilate/affilateMethod
        $payment_methods = $this->payment_method
        ->get();

        return response()->json([
            'payment_methods' => $payment_methods
        ]);
    }

    public function add(Request $request){
        // https://bdev.elmanhag.shop/admin/affilate/affilateMethodAdd
        // Keys
        // method, min_payout, status, thumbnail
        $validator = Validator::make($request->all(), [
            'method' => 'required',
            'min_payout' => 'required|numeric',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $data = $request->only($this->paymentMethodRequest);
        $thumbnail = $this->upload($request,'thumbnail','admin/affilate/thumbnail'); // Upload thumbnail
        if (!empty($thumbnail) && $thumbnail != null) {
            $data['thumbnail'] = $thumbnail; // add to data image if is found
        }
        $payment_methods = $this->payment_method
        ->create($data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function update(Request $request, $id){
        // https://bdev.elmanhag.shop/admin/affilate/affilateMethodUpdate/{id}
        // Keys
        // method, min_payout, status, thumbnail
        $validator = Validator::make($request->all(), [
            'method' => 'required',
            'min_payout' => 'required|numeric',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $data = $request->only($this->paymentMethodRequest);
        $payment_methods = $this->payment_method
        ->where('id', $id)
        ->first();
        $thumbnail = $this->upload($request,'thumbnail','admin/affilate/thumbnail'); // Upload thumbnail
        if (!empty($thumbnail) && $thumbnail != null) {
            $data['thumbnail'] = $thumbnail; // add to data image if is found
            $this->deleteImage($payment_methods->thumbnail); // delete old image
        }
        $payment_methods->update($data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/affilate/affilateMethodDelete/{id}
        $payment_methods = $this->payment_method
        ->where('id', $id)
        ->first();
        $this->deleteImage($payment_methods->thumbnail); // delete old image
        $payment_methods->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
