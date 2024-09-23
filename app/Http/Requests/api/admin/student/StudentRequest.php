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
            'name'=>['required'], 
            'phone'=>['required','unique:users'],
            'email'=>['required','unique:users', 'email'],
            'category_id'=>['required'],
            'education_id'=>['required', 'exists:education,id'],
            'password'=>['required'],
            'gender'=>['required', 'in:male,female'],
            'sudent_jobs_id'=>['required', 'exists:student_jobs,id'],
            'country_id'=>['required', 'exists:countries,id'],
            'city_id'=>['required', 'exists:cities,id'],
            'parent_name'=>['required'],
            'parent_email'=>['required', 'email'],
            'parent_password'=>['required'],
            'parent_phone'=>['required'],
        ];
    }

      public function failedValidation(Validator $validator){
      throw new HttpResponseException(response()->json([
      'message'=>'validation error',
      'errors'=>$validator->errors(),
      ],400));
      }
}
