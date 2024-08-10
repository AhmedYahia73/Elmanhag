<?php

namespace App\Http\Requests\api\admin\student;

use Illuminate\Foundation\Http\FormRequest;

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
            'firstName'=>['required'],
            'lastName'=>['required'],
            'phone'=>['required'],
            'email'=>['required'],
            'parent_name'=>['required'],
            'parent_phone'=>['required'],
            'category_id'=>['sometimes', 'required'],
            'language'=>['required'],
            'password'=>['required'],
            'conf_password'=>['required', 'same:password'],
            'country_id'=>['sometimes', 'required'],
            'city_id'=>['sometimes', 'required'],
        ];
    }
}
