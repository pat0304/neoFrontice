<?php

namespace App\Policies;

use App\Enums\AccessLevel;
use App\Enums\Permission\Permission;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChallengePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Challenge $challenge): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $admin = $user->admin;
        $roles = $admin->showRole()['permissions'];
        if (in_array('create', $roles[Permission::CHALLENGES->value])) {
            return true;
        } else return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Challenge $challenge): bool
    {
        $admin = $user->admin;
        $owner = $challenge->user->admin;
        if ($owner->id == $admin->id)
            return true;
        else if ($admin->access_level == AccessLevel::SUPER_ADMIN->value)
            return true;
        else if ($admin->access_level <= $owner->access_level)
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Challenge $challenge): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Challenge $challenge): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Challenge $challenge): bool
    {
        return false;
    }
}
