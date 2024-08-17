<?php

namespace App\Http\Requests\api\admin\bundle;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class BundleRequest extends FormRequest
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
            'name' => ['required'],
            'ar_name' => ['required'],
            'price' => ['required', 'numeric'],
            'semester' => ['required', 'in:first,second'],
            'category_id' => ['required', 'exists:categories,id'],
            'education_id' => ['required', 'exists:education,id'],
            'expired_date' => ['required', 'date']
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
