<?php

namespace App\Eloquents;

use App\Models\User;

interface UserEloquent
{
    public function getUserByEmail(string $email);

    public function getUserById(string $id);
    public function getUsernameById(string $id);
    public function getUserByUsername(string $username);
    // Create User
    public function createUser(array $data);
    public function createTaskee(array $data);

    public function verifyUser(string $email, string $password);
    public function update(User $user, array $array);
}
