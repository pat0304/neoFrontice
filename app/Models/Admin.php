<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAdmin
 */
class Admin extends Model
{
    use HasUuids;
    protected $fillable = [
        'id',
        'admin_role_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id', 'id');
    }
}
