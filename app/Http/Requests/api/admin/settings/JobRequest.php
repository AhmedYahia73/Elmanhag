<?php

namespace App\Http\Requests\api\admin\settings;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'job' => ['required'],
            'title_male' => ['required'],
            'title_female' => ['required'],
            'ar_job' => ['required'],
            'ar_title_male' => ['required'],
            'ar_title_female' => ['required'],
        ];
    }
}
