<?php
return [
    'custom' => [
        'username' => [
            'required' => 'Tên đăng nhập là bắt buộc.',
            'string'   => 'Tên đăng nhập phải là chuỗi.',
            'max'      => 'Tên đăng nhập không được vượt quá :max ký tự.',
            'unique'   => 'Tên đăng nhập đã tồn tại.',
        ],
        'first_name' => [
            'required' => 'Họ là bắt buộc.',
            'string'   => 'Họ phải là chuỗi.',
            'max'      => 'Họ không được vượt quá :max ký tự.',
        ],
        'last_name' => [
            'required' => 'Tên là bắt buộc.',
            'string'   => 'Tên phải là chuỗi.',
            'max'      => 'Tên không được vượt quá :max ký tự.',
        ],
        'email' => [
            'required' => 'Email là bắt buộc.',
            'email'    => 'Email không hợp lệ.',
            'max'      => 'Email không được vượt quá :max ký tự.',
            'unique'   => 'Email đã được sử dụng.',
        ],
        'password' => [
            'required'  => 'Mật khẩu là bắt buộc.',
            'string'    => 'Mật khẩu phải là chuỗi.',
            'min'       => 'Mật khẩu phải có ít nhất :min ký tự.',
            'confirmed' => 'Xác nhận mật khẩu không khớp.',
        ],
        'role' => [
            'required' => 'Vai trò là bắt buộc.',
            'in'       => 'Vai trò chỉ có thể là tasker hoặc taskee.',
        ],
    ],
];
