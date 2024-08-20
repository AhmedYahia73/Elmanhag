<?php

namespace App\Http\Requests\api\admin\promocode;

use Illuminate\Foundation\Http\FormRequest;

class PromocodeRequest extends FormRequest
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
            'code' => ['required'],
            'value' => ['numeric'],
            'precentage' => ['numeric'],
            'usage_type' => ['required', 'in:fixed,unlimited'],
            'usage' => ['numeric'],
            'number_users' => ['numeric'],
        ];
    }
}
