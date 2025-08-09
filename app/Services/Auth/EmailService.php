<?php

namespace App\Services\Auth;

use App\Mail\VerifyEmail;
use App\Models\Email;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailService
{

    public function create(string $email, User $user): Email
    {
        $emailModel = new Email();
        $emailModel->create([
            'email' => $email,
            'user_id' => $user->id,
            'is_active' => false,
            'is_verified' => false,
        ]);

        return $emailModel;
    }
    public function sendMail(string $email)
    {
        try {
            DB::beginTransaction();
            $emailModel = Email::where('email', $email)
                ->firstOrFail();
            $otpcode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $token = bin2hex(random_bytes(16));
            $emailModel->update([
                'otp_code' => $otpcode,
                'token' => $token,
                'expires_at' => now()->addMinutes(5),
                'is_active' => true,
            ]);
            Mail::to($email)
                ->send(new VerifyEmail([
                    'username' => $emailModel->user->username,
                    'otp_code' => $otpcode,
                    'token' => $token
                ]));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Email not found: ' . $e->getMessage());
        }
    }
    public function verifyEmailByOTP(string $otp)
    {
        try {
            DB::beginTransaction();
            $email = Email::where('otp_code', $otp)
                ->where("user_id", auth()->guard()->user()->id)
                ->first();

            if (!$email || $email->expires_at < now() || !$email->is_active) {
                return false;
            }
            $email->is_verified = true;
            $email->save();
            $user = $email->user;
            $user->is_active = true;
            $user->is_verified = true;
            $user->save();
            DB::commit();
            return $email;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Database transaction failed: ' . $e->getMessage());
        }
    }
    public function verifyEmailByToken(string $token)
    {
        try {
            DB::beginTransaction();
            $email = Email::where('token', $token)
                ->where("user_id", auth()->guard()->user()->id)
                ->first();

            if (!$email || $email->expires_at < now() || !$email->is_active) {
                return false;
            }
            $email->is_verified = true;
            $email->save();
            $user = $email->user;
            $user->is_active = true;
            $user->is_verified = true;
            $user->save();
            DB::commit();
            return $email;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Database transaction failed: ' . $e->getMessage());
        }
    }
}
