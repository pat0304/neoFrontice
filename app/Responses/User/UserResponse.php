<?php

namespace App\Responses\User;

use App\Models\User;

class UserResponse
{
    public static function make(User $user)
    {
        $activeRole = request()->get('active_role');
        if ($activeRole == 'taskee') {
            return [
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
                'bio' => $user->taskee->bio,
                'created_at' => strtotime($user->created_at)
            ];
        } elseif ($activeRole == 'tasker') {
            return [
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
                'bio' => $user->tasker->company_username,
                'tax_code' => $user->tasker->tax_code,
                'created_at' => strtotime($user->created_at)
            ];
        } elseif ($activeRole == 'admin') {
            return [
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
                'adminRole' => $user->admin->adminRole,
                'created_at' => strtotime($user->created_at)
            ];
        }
        return [
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
            'created_at' => $user->created_at->toDateTimeString()
        ];
    }
}
