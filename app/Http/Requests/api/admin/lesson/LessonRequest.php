<?php

namespace App\Http\Requests\api\admin\lesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LessonRequest extends FormRequest
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
            'name' => ['required'],
            'ar_name' => ['required'],
            'paid' => ['required'],
            'status' => ['required'],
            'switch' => ['required', 'boolean'],
            'drip_content' => ['required'], 
            'materials.*.source' => ['required', 'in:external,embedded,upload'],
            'materials.*.type' => ['required', 'in:voice,video,pdf'],
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
