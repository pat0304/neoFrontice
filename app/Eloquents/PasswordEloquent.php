<?php

namespace App\Eloquents;

interface PasswordEloquent
{
    public function sendResetLink(string $email);
    public function resetPasswordByLink(string $token, string $password);
    public function create(string $password, \App\Models\User $user, string $hash_algorithm = 'bcrypt'): \App\Models\Password;
    public function hashPassword(string $password): string;
    public function verifyPassword(string $password, string $hashedPassword): bool;
    public function changePassword(\App\Models\User $user, string $currentPassword, string $newPassword);
}
