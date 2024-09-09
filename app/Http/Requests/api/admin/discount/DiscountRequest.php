<?php

namespace App\Http\Requests\api\admin\discount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiscountRequest extends FormRequest
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
            'category_id' => ['exists:categories,id'],
            'subject_id' => ['exists:subjects,id'],
            'bundle_id' => ['exists:bundles,id'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', 'in:percentage,value'],
            'description' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'statue' => ['required', 'boolean']
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
