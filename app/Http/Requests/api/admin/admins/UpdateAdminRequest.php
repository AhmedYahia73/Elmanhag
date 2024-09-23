<?php

namespace App\Http\Requests\api\admin\admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
        $userId = $this->route('id');
        return [
            // this request from admin for add new Admin
            'name'=>['required'],
            'phone'=>['required', Rule::unique('users')->ignore($userId)],
            'email'=>['required', Rule::unique('users')->ignore($userId), 'email'],
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
