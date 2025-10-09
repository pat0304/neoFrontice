<?php

namespace App\Services\Auth;

use App\Eloquents\PasswordEloquent;
use App\Models\Email;
use App\Models\Password;
use App\Models\User;
use App\Responses\BaseResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordService implements PasswordEloquent
{
    public function create(string $password, User $user, string $hash_algorithm = 'bcrypt'): Password
    {
        $new = Password::useCreate($password, $user, $hash_algorithm);
        return $new;
    }
    public function changePassword(User $user, string $currentPassword, string $newPassword)
    {
        if (!$this->verifyPassword($currentPassword, $user->password)) {
            return false;
        } else {
            return $this->create($newPassword, $user);
        }
    }
    /**
     * Hash the given password.
     *
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Verify the given password against the hashed password.
     *
     * @param string $password
     * @param string $hashedPassword
     * @return bool
     */
    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }

    public function sendResetLink(string $email)
    {
        $emailModel = Email::where('email', $email)->where('is_active', true)->first();
        if (!$emailModel) {
            abort(BaseResponse::notFound('account not found'));
        }

        $user = $emailModel->user;
        if (!$user) {
            abort(BaseResponse::notFound());
        }
        DB::transaction(function () use ($email, $user) {
            $otpCode = rand(100000, 999999);
            $token = \Illuminate\Support\Str::random(32);

            $user->password()->update([
                'token' => $token,
                'otp_code' => $otpCode,
                'expires_at' => now()->addMinutes(15),
                'otp_sent_at' => now()
            ]);
            \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\ResetPassword([
                'username' => $user->username,
                'otp_code' => $otpCode,
                'token' => $token,
            ]));
        });
    }
    public function resetPasswordByLink(string $token, string $password): Password
    {
        $passwordModel = Password::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();
        if (!$passwordModel) {
            abort(BaseResponse::error(__("messages.data_invalid"), 400));
        }
        $user = $passwordModel->user;
        $output = $this->create($password, $user);

        return $output;
    }
}
