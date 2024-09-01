<?php

namespace App\Http\Requests\api\admin\student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStudentRequest extends FormRequest
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
            // this request from admin for Update Student
            'name'=>['required'],
            'phone'=>['required'],
            'email'=>['required', 'email'],
            'parent_name'=>['required'],
            'parent_phone'=>['required'],
            'parent_email'=>['required', 'email'],
            'parent_password'=>['required'],
            'category_id'=>['sometimes', 'required'],
            'education_id'=>['required'],
            'password'=>['required'],
            'country_id'=>['sometimes', 'required'],
            'city_id'=>['sometimes', 'required'],
            'status'=>['required'],
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
