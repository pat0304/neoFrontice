<?php

namespace App\Services;

use App\Eloquents\UserEloquent;
use App\Models\User;
use App\Models\Email;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Services\Auth\PasswordService;

class UserService implements UserEloquent
{
    // Get User
    public function getUserByEmail(string $email)
    {
        $user = Email::where('email', $email)->where('is_active', true)
            ->firstOrFail()
            ->user()
            ->with(['avatar', 'cv'])
            ->first();
        return $user;
    }

    public function getUserById(string $id)
    {
        $user = User::where('id', $id)->where('is_active', true)
            ->with(['avatar', 'cv'])
            ->firstOrFail();
        return $user;
    }
    public function getUsernameById(string $id)
    {
        $user = User::where('id', $id)
            ->firstOrFail();
        return $user->username;
    }
    public function getUserByUsername(string $username)
    {
        $user = User::where('username', $username)->where('is_active', true)
            ->with(['avatar', 'cv'])
            ->firstOrFail();
        return $user;
    }
    // Create User
    public function createUser(array $data)
    {
        $data['username'] = Str::lower($data['username']);
        $user = new User();
        $user->fill($data);
        $user->save();

        return $user;
    }
    public function createTaskee(array $data) {}

    public function verifyUser(string $email, string $password)
    {
        $passwordModel = new PasswordService();
        try {
            $emailModel = Email::where('email', $email)->firstOrFail();
            $user = $emailModel->user()->with(['avatar', 'cv', 'roles'])->first();
        } catch (\Exception $e) {
            throw new \Exception('User not found: ' . $e->getMessage());
        }

        if (!$user || !$user->password) {
            return false;
        }
        if (!Hash::check($password, $user->password)) {
            return false;
        }

        return $user;
    }
    public function update(User $user, array $array)
    {
        $filter_array = array_filter($array, fn($value) => !is_null($value));
        $user = $user->useUpdate($filter_array);
    }
}
