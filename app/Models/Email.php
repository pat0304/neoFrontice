<?php

namespace App\Models;

use App\Casts\TimestampCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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
        'expires_at' => TimestampCast::class,
        'created_at' => TimestampCast::class,
        'updated_at' => TimestampCast::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
