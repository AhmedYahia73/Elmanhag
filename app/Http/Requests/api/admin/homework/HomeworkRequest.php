<?php

namespace App\Http\Requests\api\admin\homework;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HomeworkRequest extends FormRequest
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
            'title' => ['required', 'in:H.W1,H.W2,H.W3'],
            'semester' => ['required', 'in:first,second'],
            'due_date' => ['required', 'date'],
            'category_id' => ['required', 'exists:categories,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'chapter_id' => ['required', 'exists:chapters,id'],
            'lesson_id' => ['required', 'exists:lessons,id'],
            'difficulty' => ['required', 'in:A,B,C'],
            'mark' => ['required', 'numeric'],
            'pass' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function failedValidation(Validator $validator){
       throw new HttpResponseException(response()->json([
               'message'=>'validation error',
               'errors'=>$validator->errors(),
       ],400));
   }
}
