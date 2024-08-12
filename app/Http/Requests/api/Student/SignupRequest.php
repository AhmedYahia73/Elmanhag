<?php

namespace App\Http\Requests\api\student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class SignupRequest extends FormRequest
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
            // This About All Name Request and Validate Request 
    'name' => ['required'],
    'email' => ['email', 'unique:users', 'required'],
    'password' => ['required'],
    'conf_password' => ['required', 'same:password'],
    'phone' => ['required', 'unique:users'],
    'city_id' => ['required','exists:cities,id'],
    'country_id' => ['required','exists:countries,id'],
    'category_id' => ['required','exists:categories,id'],
        ];
    }
    public function failedValidation(Validator $validator){
    throw new HttpResponseException(response()->json([
    'message'=>'validation error',
    'errors'=>$validator->errors(),
    ],400));
    }
}
