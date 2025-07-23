<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
