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
        'tax_code' => [
            'required_if' => 'Mã số thuế là bắt buộc khi vai trò là tasker',
        ],
        'company_name' => [
            'required_if' => 'Tên công ty là bắt buộc khi vai trò là tasker',
        ],
        'level_id' => [
            'required' => 'Cần nhập Level ID.',
            'integer'  => 'Level ID phải là số nguyên.',
            'exists'   => 'Level ID không tồn tại.',
        ],
        'locale' => [
            'required' => 'Cần nhập mã ngôn ngữ.',
            'string'   => 'Mã ngôn ngữ phải là chuỗi.',
            'size'     => 'Mã ngôn ngữ phải gồm đúng 2 ký tự.',
        ],
        'title' => [
            'required' => 'Cần nhập tiêu đề.',
            'string'   => 'Tiêu đề phải là chuỗi.',
            'max'      => 'Tiêu đề không được vượt quá :max ký tự.',
        ],
        'desc' => [
            'string' => 'Mô tả phải là chuỗi.',
        ],
        'short_desc' => [
            'required' => 'Cần nhập mô tả ngắn.',
            'string'   => 'Mô tả ngắn phải là chuỗi.',
            'max'      => 'Mô tả ngắn không được vượt quá :max ký tự.',
        ],
        'technicals' => [
            'required' => 'Cần ít nhất một kỹ năng kỹ thuật.',
            'array'    => 'Trường technicals phải là một mảng.',
            'min'      => 'Phải có ít nhất một kỹ năng trong technicals.',
        ],
        'technicals.*' => [
            'string' => 'Mỗi phần tử trong technicals phải là chuỗi.',
            'max'    => 'Mỗi phần tử trong technicals không được vượt quá :max ký tự.',
        ],
        'attachment' => [
            'required' => 'Cần nhập đường dẫn tệp đính kèm.',
            'string'   => 'Đường dẫn tệp đính kèm phải là chuỗi.',
        ],
        'source' => [
            'required' => 'Cần nhập đường dẫn mã nguồn.',
            'string'   => 'Đường dẫn mã nguồn phải là chuỗi.',
        ],
        'figma' => [
            'required' => 'Cần nhập liên kết Figma.',
            'string'   => 'Liên kết Figma phải là chuỗi.',
        ],
    ],
];
