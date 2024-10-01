<?php

namespace App\Http\Requests\api\affiliate;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AfilliateRequest extends FormRequest
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
            // This Request About All Affilates
        'name'=>['required'],
        'email'=>['required','unique:users'],
        'phone'=>['required','unique:users'],
        'country_id' => ['required', 'exists:countries,id'],
        'city_id' => ['required', 'exists:cities,id'],
        'password' => ['required'],
        'conf_password' => ['required', 'same:password'],
        ];
    }
 public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message'=>'Validation Error',
            'error'=>$validator->errors(),
        ]));
 }

   
}
