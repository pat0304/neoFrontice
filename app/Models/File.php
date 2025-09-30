<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperFile
 */
class File extends Model
{
    use HasUuids;
    protected $fillable = ['user_id', 'fileable_type', 'fileable_id', 'original_name', 'file_path', 'mime_type', 'size', 'usage', 'visibility', 'storage_disk'];
    protected $casts = [
        'user_id' => 'string',
        'fileable_id' => 'string',
        'size' => 'integer',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getUrlAttribute()
    {
        if ($this->storage_disk === 'gcs') {
            if ($this->visibility === 'public') {
                return gcs_temporary_url($this->file_path, 10);
            } else {
                return gcs_temporary_url($this->file_path, 1);
            }
        }
        if ($this->visibility === 'public') {
            return Storage::disk($this->storage_disk)->temporaryUrl($this->file_path, now()->addMinutes(10));
        } else {
            return Storage::disk($this->storage_disk)->temporaryUrl($this->file_path, now()->addMinulàtes(1));
        }
    }
}
