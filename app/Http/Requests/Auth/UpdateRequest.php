<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $rules =  [
            'username' => 'nullable|string|max:255|unique:users,username,' . auth()->guard()->user()->username,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ];

        $role = $this->get('active_role');

        if ($role === 'taskee') {
            $rules += ['bio' => 'nullable|string'];
        } elseif ($role === 'tasker') {
            $rules += [
                'company_name' => 'nullable|string|max:255',
                'tax_code'     => 'nullable|string|max:25',
            ];
        }

        return $rules;
    }
}
