<?php

namespace App\Eloquents;

use App\Models\Email;
use App\Models\User;

interface EmailEloquent
{
    public function create(string $email, User $user): Email;

    public function sendMail(string $email);

    public function verifyEmailByOTP(string $otp);

    public function verifyEmailByToken(string $token);
}
