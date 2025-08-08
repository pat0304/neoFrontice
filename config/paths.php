<?php
return [
    'auth' => [
        'register' => 'auth/register',
        'login' => 'auth/login',
        'logout' => 'auth/logout',
        'refresh' => 'auth/refresh',
        'profile' => 'auth/profile',
        'email' => [
            'verify' => 'auth/email/verify?token=',
            'resend' => 'auth/email/resend',
        ]
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
