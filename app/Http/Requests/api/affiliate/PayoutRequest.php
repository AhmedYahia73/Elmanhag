<?php

namespace App\Http\Requests\api\affiliate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PayoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'payment_method_affilate_id'=>['required','exists:payment_method_affilates,id'],
            'amount'=>['required','numeric'],
        ];
    }

     public function failedValidation(Validator $validator){
     throw new HttpResponseException(response()->json([
     'message'=>'Validation Error',
     'error'=>$validator->errors(),
     ]));
     }
}
