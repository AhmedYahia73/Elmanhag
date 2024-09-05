<?php

namespace App\Http\Requests\api\student;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //This Request About Any request to place order 
            'amount'=>['required'],
            'service'=>['required'],
            'payment_method_id'=>['required','exists:payment_methods'],
            'receipt'=>['required'],
            'bundle_id'=>['required','exists:bundles'],
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message'=>'error Validate',
            'error'=>$validator->errors(),
        ],400));
    }
}
