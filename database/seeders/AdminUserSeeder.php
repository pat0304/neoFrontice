<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::useCreate(
            [
                'username' => 'ROOT',
                'email'    => 'admin@frontice.com',
                'password' => '12345678',
                'role'     => 'admin',
                'first_name' => 'Admin',
                'last_name'  => 'Frontice',
                'is_active'  => true,
                'admin_role_id' => \App\Models\AdminRole::where('name', 'root')->first()->id,
                'access_level'  => \App\Enums\AccessLevel::SUPER_ADMIN,
            ]
        );
    }
}
