<?php

namespace App\Http\Requests\api\auth;

use Illuminate\Foundation\Http\FormRequest;

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
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => ['email', 'unique:users', 'required'],
            'password' => ['required'],
            'conf_password' => ['required', 'same:password'],
            'parent_name' => ['required'],
            'parent_phone' => ['required'],
            'phone' => ['required', 'unique:users'],
            'city_id' => ['required'],
            'country_id' => ['required'],
            'category_id' => ['required'],
        ];
    }


    // public function failedValidation(Validator $validator){
    //      throw new HttpResponseException(response()->json([
    //              'message'=>'validation error',
    //              'errors'=>$validator->errors(),
    //      ],400));
    //  }
}
