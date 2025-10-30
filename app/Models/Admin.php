<?php

namespace App\Models;

use App\Enums\AccessLevel;
use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @mixin IdeHelperAdmin
 */
class Admin extends Model
{
    use HasUuids, Historiable;
    protected $fillable = [
        'id',
        'admin_role_id',
        'access_level',
    ];
    protected $with = ['adminRole'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id', 'id');
    }
    public static function useCreate(array $attributes)
    {
        if (!isset($attributes['role']) || $attributes['role'] !== 'admin') {
            $attributes['role'] = 'admin';
        }
        $user = User::useCreate($attributes);
        if ($user) {
            DB::transaction(function () use ($user, $attributes) {
                Role::create(['user_id' => $user->id, 'role' => 'admin', 'main' => true]);
                Admin::create([
                    'id' => $user->id,
                    'admin_role_id' => $attributes['admin_role_id'],
                    'access_level' => $attributes['access_level'] ?? AccessLevel::SUPPORT,
                ]);
            });
        } else {
            throw new \Exception("Failed to create user for admin");
        }
    }
    /**
     * Show role with permissions
     * @return array [access_level: int, permissions: [string Role, array Actions]]
     */
    public function showRole()
    {
        $permissions = [];
        foreach ($this->adminRole->permissions as $permission) {
            $detail = explode('.', $permission->name);
            $permissions[$detail[0]][] = $detail[1];
        }
        return [
            'access_level' => $this->access_level,
            'permissions' => $permissions,
        ];
    }
}
