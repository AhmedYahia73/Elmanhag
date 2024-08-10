<?php

namespace App\Http\Requests\api\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;
class LoginRequest extends FormRequest
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
              'email'=>['required','email'],
              'password'=>['required'],
        ];
    }


   public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
                'message'=>'validation error',
                'errors'=>$validator->errors(),
        ],400));
    }
}
