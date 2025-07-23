<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasUuids;
    protected $fillable = ['user_id', 'fileable_type', 'fileable_id', 'original_name', 'file_path', 'mime_type', 'size', 'usage', 'visibility'];
    protected $casts = [
        'user_id' => 'string',
        'fileable_id' => 'string',
        'size' => 'integer',
        'visibility' => 'boolean',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
