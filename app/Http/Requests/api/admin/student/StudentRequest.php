<?php

namespace App\Http\Requests\api\admin\student;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentRequest extends FormRequest
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
            // this request from admin for create new Student
            'firstName'=>['required'],
            'lastName'=>['required'],
            'phone'=>['required','unique:users'],
            'email'=>['required','unique:users'],
            'parent_name'=>['required'],
            'parent_phone'=>['required'],
            'category_id'=>['required'],
            'language'=>['required'],
            'password'=>['required'],
            'conf_password'=>['required', 'same:password'],
            'country_id'=>['required'],
            'city_id'=>['required'],
        ];
    }

      public function failedValidation(Validator $validator){
      throw new HttpResponseException(response()->json([
      'message'=>'validation error',
      'errors'=>$validator->errors(),
      ],400));
      }
}
