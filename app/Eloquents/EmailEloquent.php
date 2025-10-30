<?php

namespace App\Eloquents;

use App\Models\Email;
use App\Models\User;

interface EmailEloquent
{

    public function sendMail(string $email);

    public function verifyEmailByOTP(string $otp);

    public function verifyEmailByToken(string $token);
    // public funtion addEmail(User $user, string $email);
}
