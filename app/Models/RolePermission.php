<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'admin_role_id',
        'permission_id',
    ];

    public function role()
    {
        return $this->belongsTo(AdminRole::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}
