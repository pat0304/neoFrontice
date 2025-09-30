<?php

namespace App\Services;

use App\Eloquents\AdminEloquent;
use App\Models\AdminRole;
use Illuminate\Support\Facades\DB;

class AdminService implements AdminEloquent
{
    public function createAdmin($email, $last_name, $first_name, AdminRole $role)
    {
        DB::transaction(function () {
            
        });
    }
}
