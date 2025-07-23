<?php

namespace App\Models;

use App\Casts\TimestampCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasUuids;

    protected $fillable = ['user_id', 'title', 'content', 'is_read', 'trigger_type', 'trigger_id'];

    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'is_read' => 'boolean',
        'created_at' => TimestampCast::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
