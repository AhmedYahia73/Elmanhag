<?php

namespace App\Http\Requests\api\parent\childreen;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChildProfileRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'education_id' => ['required', 'exists:education,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
