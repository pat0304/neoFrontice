<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperPermission
 */
class Permission extends Model
{
    protected $fillable = [
        'name',
        'desc',
    ];

    public function adminRole(): BelongsToMany
    {
        return $this->belongsToMany(AdminRole::class, 'role_permissions', 'permission_id', 'admin_role_id')->withTimestamps();
    }
}
