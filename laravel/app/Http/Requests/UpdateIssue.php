<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIssue extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'summary' => [
                'string',
                'required',
                'max:128',
                'min:4',
            ],
            'description' => [
                'string',
                'required',
                'max:128',
                'min:4',
            ],
        ];
    }
}
