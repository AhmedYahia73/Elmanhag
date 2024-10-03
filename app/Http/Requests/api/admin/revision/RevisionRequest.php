<?php

namespace App\Http\Requests\api\admin\revision;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RevisionRequest extends FormRequest
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
            'title' => ['required'],
            'semester' => ['required', 'in:first,second'],
            'category_id' => ['required', 'exists:categories,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'mark' => ['required', 'numeric'],
            'type' => ['required', 'in:monthly,final'],
            'month' => ['required', 'numeric'],
            'mark' => ['required', 'numeric'],
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
