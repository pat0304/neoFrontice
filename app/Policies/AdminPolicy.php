<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Responses\BaseResponse;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;

class AdminPolicy extends BasePolicy
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
    public function view(User $user, Admin $admin): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Admin $admin): bool
    {
        $isValid = $this->canManage($user, $admin->user);

        return $isValid ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Admin $admin): bool|JsonResponse
    {
        $isValid = $this->canManage($user, $admin->user);
        if ($isValid && $user->id !== $admin->user->id) {
            return true;
        } elseif ($user->id === $admin->user->id) {
            return BaseResponse::forbidden('You cannot delete yourself.');
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Admin $admin): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Admin $admin): bool
    {
        return false;
    }
}
