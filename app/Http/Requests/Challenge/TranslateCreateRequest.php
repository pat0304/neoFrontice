<?php

namespace App\Http\Requests\Challenge;

use Illuminate\Foundation\Http\FormRequest;

class TranslateCreateRequest extends FormRequest
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
            'locale'       => ['required', 'string', 'size:2'], // e.g. 'en', 'vi'
            'title'        => ['required', 'string', 'max:255'],
            'desc'         => ['nullable', 'string'],
            'short_desc'   => ['required', 'string', 'max:500'],
        ];
    }
}
