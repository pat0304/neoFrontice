<?php
return [
    'auth' => [
        'register' => 'auth/register',
        'login' => 'auth/login',
        'logout' => 'auth/logout',
        'refresh' => 'auth/refresh',
        'profile' => 'auth/profile',
        'email' => [
            'verify' => 'v1/auth/email/verify?token=',
            'resend' => 'v1/auth/email/resend',
        ],
        'password' => [
            'change' => 'auth/password/change',
            'send_mail' => 'v1/auth/password/send-mail',
            'reset' => 'v1/auth/password/reset?token=',
        ],
    ],
    'files' => [
        'avatar' => 'files/avatar',
        'cv' => 'files/cv',
        'attachment' => 'files/attachment',
        'source' => 'files/source',
        'figma' => 'files/figma',
    ],
    // Add more paths as needed
];
