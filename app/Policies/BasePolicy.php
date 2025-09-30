<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    public function isAdmin()
    {
        if (auth()->check() && in_array('admin', auth()->user()->role)) {
            return true;
        }
        return false;
    }
    public function canManage(User $user, User $owner)
    {
        if ($user->id === $owner->id) {
            return true;
        }
        if ($user->admin->access_level < $owner->admin->access_level) {
            return true;
        }
        return false;
    }
}
