<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'path' => 'required|string',
            'usage' => 'nullable|string|in:avatar,other,source,figma,cv',
            'fileable_type' => 'nullable|string',
            'fileable_id' => 'nullable|string',
            'visibility' => 'nullable|string|in:public,private',
        ];
    }
}
