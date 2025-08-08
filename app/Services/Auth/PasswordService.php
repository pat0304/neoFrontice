<?php

namespace App\Services\Auth;

use App\Models\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public function create(string $password, User $user,  string $hash_algorithm = 'bcrypt')
    {
        $passwordModel = new Password();
        $passwordModel->create([
            'user_id' => $user->id,
            'password' => bcrypt($password),
            'hash_algorithm' => $hash_algorithm
        ]);
        return $passwordModel;
    }
    /**
     * Update the user's password.
     *
     * @param User $user
     * @param string $password
     * @param string $hash_algorithm
     * @return Password|bool
     */
    public function update(User $user, string $password, string $hash_algorithm = 'bcrypt')
    {
        $passwordModel = new Password();
        $passwords  = $user->passwords();
        if (!$passwords->isEmpty()) {
            foreach ($passwords as $key) {
                if ($this->verifyPassword($password, $key->password)) {
                    return false;
                }
            }
        }
        $passwordModel = $this->create($password, $user, $hash_algorithm);
        return $passwordModel;
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
        return password_verify($password, $hashedPassword);
    }
}
