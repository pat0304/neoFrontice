<?php

namespace App\Services;

use App\Eloquents\PasswordEloquent;
use App\Models\Email;

class PasswordService implements PasswordEloquent
{
    public function sendResetLink(string $email)
    {
        $emailModel = Email::where('email', $email)->where('is_verified', true)->first();
        if (!$emailModel) {
            throw new \Exception(__("messages.not_found"));
        }
        $user = $emailModel->user();
        if (!$user) {
            throw new \Exception(__("messages.not_found"));
        }
        $user->passwords()->create([
            'token' => \Illuminate\Support\Str::random(64),
            'expires_at' => now()->addMinutes(15),
            'otp_send_at' => now()
        ]);
    }
    public function resetPassword(array $data) {}
}
