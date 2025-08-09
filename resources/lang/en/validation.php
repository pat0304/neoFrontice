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
    ],
];
