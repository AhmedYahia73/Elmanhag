<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\settings\PaymentMethodRequest;
use App\trait\image;

use App\Models\PaymentMethod;

class PaymentMethodsController extends Controller
{
    use image;   
    protected $paymentMethodRequest = [
        'title',
        'description',
        'status',
    ];
    public function __construct(private PaymentMethod $payment_methods){}
 
    public function show(){
        // https://bdev.elmanhag.shop/admin/Settings/paymentMethods
        $payment_methods = $this->payment_methods
        ->get();

        return response()->json([
            'payment_methods' => $payment_methods
        ]);
    }

    public function create(PaymentMethodRequest $request){
        // https://bdev.elmanhag.shop/admin/Settings/paymentMethods/add
        // Keys
        // title, description, thumbnail, status
        $payment_method_data = $request->only($this->paymentMethodRequest);
        $image =  $this->upload($request,'thumbnail','admin/settings/paymentMethods/thumbnail'); // Upload Thumbnail
        $payment_method_data['thumbnail'] = $image;
        $this->payment_methods->create($payment_method_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(PaymentMethodRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/Settings/paymentMethods/update/{id}
        // Keys
        // title, description, thumbnail, status
        $payment_method_data = $request->only($this->paymentMethodRequest);
        $payment_method = $this->payment_methods
        ->where('id', $id)
        ->first(); // Get Data of Payment Method
        $image =  $this->upload($request,'thumbnail','admin/settings/paymentMethods/thumbnail'); // Upload Thumbnail
        if ( !empty($image) && $image != null ) {
            $this->deleteImage($payment_method->thumbnail); // Delete old Thumbnail
            $payment_method_data['thumbnail'] = $image;
        }
        $payment_method->update($payment_method_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/Settings/paymentMethods/delete/{id}
        $payment_method = $this->payment_methods
        ->where('id', $id)
        ->first();
        $this->deleteImage($payment_method->thumbnail); // Delete old Thumbnail
        $payment_method->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
