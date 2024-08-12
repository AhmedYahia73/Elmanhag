<?php

namespace App\Http\Requests\api\admin\lesson;

use Illuminate\Foundation\Http\FormRequest;

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
            'chapter_id' => ['required', 'exists:chapters,id'],
            'status' => ['required'],
            'drip_content' => ['required']
        ];
    }
}
