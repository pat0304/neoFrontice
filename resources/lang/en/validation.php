<?php
return [
    'custom' => [
        'username' => [
            'required' => 'Username is required.',
            'string'   => 'Username must be a string.',
            'max'      => 'Username may not be greater than :max characters.',
            'unique'   => 'Username already exists.',
        ],
        'first_name' => [
            'required' => 'First name is required.',
            'string'   => 'First name must be a string.',
            'max'      => 'First name may not be greater than :max characters.',
        ],
        'last_name' => [
            'required' => 'Last name is required.',
            'string'   => 'Last name must be a string.',
            'max'      => 'Last name may not be greater than :max characters.',
        ],
        'email' => [
            'required' => 'Email is required.',
            'email'    => 'Email must be a valid email address.',
            'max'      => 'Email may not be greater than :max characters.',
            'unique'   => 'Email has already been taken.',
        ],
        'password' => [
            'required'  => 'Password is required.',
            'string'    => 'Password must be a string.',
            'min'       => 'Password must be at least :min characters.',
            'confirmed' => 'Password confirmation does not match.',
        ],
        'role' => [
            'required' => 'Role is required.',
            'in'       => 'Role must be either tasker or taskee.',
        ],
        'tax_code' => [
            'required_if' => 'Tax code is required when role is tasker',
        ],
        'company_name' => [
            'required_if' => 'Company name is required when role is tasker',
        ],
        'level_id' => [
            'required' => 'Level ID is required.',
            'integer'  => 'Level ID must be an integer.',
            'exists'   => 'Level ID does not exist.',
        ],
        'locale' => [
            'required' => 'Locale is required.',
            'string'   => 'Locale must be a string.',
            'size'     => 'Locale must be exactly 2 characters.',
        ],
        'title' => [
            'required' => 'Title is required.',
            'string'   => 'Title must be a string.',
            'max'      => 'Title may not be greater than :max characters.',
        ],
        'desc' => [
            'string' => 'Description must be a string.',
        ],
        'short_desc' => [
            'required' => 'Short description is required.',
            'string'   => 'Short description must be a string.',
            'max'      => 'Short description may not be greater than :max characters.',
        ],
        'technicals' => [
            'required' => 'At least one technical is required.',
            'array'    => 'Technicals must be an array.',
            'min'      => 'You must include at least one technical.',
        ],
        'technicals.*' => [
            'string' => 'Each technical must be a string.',
            'max'    => 'Each technical may not be greater than :max characters.',
        ],
        'attachment' => [
            'required' => 'Attachment is required.',
            'string'   => 'Attachment must be a string.',
        ],
        'source' => [
            'required' => 'Source is required.',
            'string'   => 'Source must be a string.',
        ],
        'figma' => [
            'required' => 'Figma link is required.',
            'string'   => 'Figma link must be a string.',
        ],
    ],
];
