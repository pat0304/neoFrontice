<?php

namespace App\Eloquents;

use App\Models\AdminRole;


interface AdminEloquent
{
    public function createAdmin($email, $last_name, $first_name,  AdminRole $role);
}