<?php

namespace App\Models;

use App\Casts\TimestampCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperEmail
 */
class Email extends Model
{
    use HasUuids;
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
}
