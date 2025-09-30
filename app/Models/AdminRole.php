<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperAdminRole
 */
class AdminRole extends Model
{
    protected $table = 'admin_roles';

    protected $fillable = [
        'name',
        'desc',
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'admin_role_id', 'permission_id')->withTimestamps();
    }
}
