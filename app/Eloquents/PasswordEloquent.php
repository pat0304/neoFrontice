<?php

namespace App\Eloquents;

interface PasswordEloquent
{
    public function sendResetLink(string $email);
    public function resetPassword(array $data);
}