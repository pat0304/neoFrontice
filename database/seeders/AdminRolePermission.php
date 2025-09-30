<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminRolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (AdminRole::count() == 0) {
            AdminRole::create(['name' => 'root', 'desc' => 'Super Admin Role']);
        }
        if (Permission::count() == 0) {
            $permissions = [];
            foreach (\App\Enums\Permission\Permission::cases() as $permission) {
                $permissions = array_merge($permissions, $permission->crud());
                AdminRole::create(['name' => $permission->value]);
            }
            foreach ($permissions as $permission) {
                $new = Permission::create(['name' => $permission]);
                AdminRole::where('name', 'root')->first()->permissions()->attach($new);
                $role = explode('.', $permission)[0];
                AdminRole::where('name', $role)->first()->permissions()->attach($new);
            }
        }
    }
}
