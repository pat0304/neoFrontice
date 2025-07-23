<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'desc',
    ];

    public function rolePermission()
    {
        return $this->hasMany(RolePermission::class);
    }
}
