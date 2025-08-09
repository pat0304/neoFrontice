<?php

namespace App\Services\Auth;

use App\Models\Role;
use App\Models\User;

class RoleService
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function create($role)
    {
        $newRole = new Role([
            'user_id' => $this->user->id,
            'role'    => $role,
            'main'    => $this->user->roles()->count() < 1
        ]);
        $newRole->save();

        if ($role == null || $role === 'taskee') {
            $this->user->taskee()->create([]);
        } elseif ($role === 'tasker') {
            $this->user->tasker()->create([]);
        }
        return $newRole;
    }
}
