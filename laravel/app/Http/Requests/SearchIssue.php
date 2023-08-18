<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchIssue extends FormRequest
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
        ];
    }

    /**
     * @return array<string>
     */
    public function getKeywords(): array
    {
        $q = $this->input('q') ?? '';
        $q = mb_convert_kana($q, 's');
        return array_filter(preg_split('/\s+/', $q));
    }
}
