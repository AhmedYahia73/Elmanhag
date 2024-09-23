<?php

namespace App\Http\Requests\api\admin\admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminRequest extends FormRequest
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
            // this request from admin for add new Admin
            'name'=>['required'],
            'phone'=>['required', 'unique:users,phone'],
            'email'=>['required', 'unique:users,email', 'email'],
            'status'=>['required', 'boolean'],
            'password'=>['required'],
            'admin_position_id'=>['required', 'exists:admin_positions,id'],
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
