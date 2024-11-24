<?php

namespace App\Http\Requests\api\admin\live_recorded;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LiveRecordedRequest extends FormRequest
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
            'video' => ['required'],
            'category_id' => ['exists:categories,id'],
            'chapter_id' => ['exists:chapters,id', 'nullable'],
            'lesson_id' => ['exists:lessons,id', 'nullable'],
            'subject_id' => ['exists:subjects,id'],
            'paid' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
            'semester' => ['required', 'in:first,second']
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
