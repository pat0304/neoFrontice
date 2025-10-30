<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRolePermission
 */
class RolePermission extends Model
{
    use \App\Traits\Historiable;
    protected $fillable = [
        'admin_role_id',
        'permission_id',
    ];
}
