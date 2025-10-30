<?php

namespace App\Http\Requests\Challenge;

use Illuminate\Foundation\Http\FormRequest;

class ChallengeCreateRequest extends FormRequest
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
            'level_id'     => ['required', 'integer', 'exists:levels,id'],
            'locale'       => ['required', 'string', 'size:2'], // e.g. 'en', 'vi'
            'title'        => ['required', 'string', 'max:255'],
            'desc'         => ['nullable', 'string'],
            'short_desc'   => ['required', 'string', 'max:500'],
            'technicals'   => ['required', 'array', 'min:1'],
            'technicals.*' => ['string', 'max:100'], // each technical item
            'attachment'   => ['required', 'string'],
            'source'       => ['required', 'string'],
            'figma'        => ['required', 'string'],
        ];
    }
}
