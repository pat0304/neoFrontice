<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function rolePermission(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }
}
