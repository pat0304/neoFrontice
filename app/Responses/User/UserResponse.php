<?php

namespace App\Responses\User;

use App\Models\User;
use App\Responses\BaseResponse;

class UserResponse extends BaseResponse
{
    public function __invoke(User $user)
    {
        return $this->success($this->make($user));
    }
    public static function make(User $user)
    {
        $activeRole = request()->get('active_role');

        $base = [
            'id' => $user->id,
            'username' => $user->username,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'is_active' => $user->is_active,
            'is_verified' => $user->is_verified,
            'role' => $user->role,
            'links' => $user->link,
            'avatar' => $user->avatar,
            'created_at' => $user->created_at->toISOString()
        ];

        return match ($activeRole) {
            'taskee' => array_merge($base, [
                'bio' => optional($user->taskee)->bio,
            ]),
            'tasker' => array_merge($base, [
                'bio' => optional($user->tasker)->company_username,
                'tax_code' => optional($user->tasker)->tax_code,
            ]),
            'admin' => array_merge($base, [
                'adminRole' => optional($user->admin)->adminRole,
            ]),
            default => $base,
        };
    }
}
