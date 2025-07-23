<?php

namespace App\Models;

use App\Casts\TimestampCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    use HasUuids;
    protected $fillable = ['id', 'user_id', 'password', 'hash_algorithm', 'otp_code', 'token', 'is_verified', 'otp_sent_at', 'expires_at'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'is_verified' => 'boolean',
        'otp_sent_at' => TimestampCast::class,
        'expired_in' => TimestampCast::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
