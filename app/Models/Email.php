<?php

namespace App\Models;

use App\Casts\TimestampCast;
use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperEmail
 */
class Email extends Model
{
    use HasUuids, Historiable;
    protected $fillable = ['id', 'user_id', 'email', 'otp_code', 'token', 'is_verified', 'is_active', 'expires_at'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function useCreate(string $email, User $user, bool $active = false, bool $verified =  false): Email
    {
        $emailModel = self::create([
            'email' => $email,
            'user_id' => $user->id,
            'is_active' => $active,
            'is_verified' => $verified
        ]);

        return $emailModel;
    }
}
