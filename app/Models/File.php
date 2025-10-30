<?php

namespace App\Models;

use App\Traits\Historiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Redis;

/**
 * @mixin IdeHelperFile
 */
class File extends Model
{
    use HasUuids, Historiable;
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
        $redisKey = "user:{$this->user_id}:{$this->usage}";
        if ($url = Redis::get($redisKey))
            return $url;
        $url = null;
        if ($this->storage_disk === 'gcs') {
            if ($this->visibility === 'public') {
                $url = gcs_temporary_url($this->file_path, 10);
                Redis::setex($redisKey, 60 * 10, $url);
            } else {
                $url = gcs_temporary_url($this->file_path, 1);
                Redis::setex($redisKey, 60, $url);
            }
            return $url;
        }
        if ($this->visibility === 'public') {
            $url = Storage::disk($this->storage_disk)->temporaryUrl($this->file_path, now()->addMinutes(10));
            Redis::setex($redisKey, 60 * 10, $url);
        } else {
            $url = Storage::disk($this->storage_disk)->temporaryUrl($this->file_path, now()->addMinutes(1));
            Redis::setex($redisKey, 60, $url);
        }
        return $url;
    }

    public static function upload($file)
    {
        $filename = $file->getClientOriginalName();
        $path = 'temp/' . auth()->guard()->user()->id . strtotime(now()) . '_' . Str::random(16);
        $storage_disk = 's3';
        DB::beginTransaction();
        try {
            $s3Storage = Storage::disk($storage_disk)->put($path, file_get_contents($file));
            if (!$s3Storage) {
                $storage_disk = 'gcs';
                $gcsStorage = Storage::disk($storage_disk)->put($path, file_get_contents($file));
                if (!$gcsStorage) {
                    $storage_disk = 'local';
                    $localStorage = Storage::disk($storage_disk)->put($path, file_get_contents($file));
                    if (!$localStorage)
                        throw new \Exception("Upload failed: return false");
                }
            }
            $fileModel = self::create([
                'user_id' => auth()->guard()->user()->id,
                'original_name' => $filename,
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'usage' => 'temp',
                'visibility' => 'private',
                'storage_disk' => $storage_disk,
            ]);
            DB::commit();
            return ['link' => $fileModel->url, 'file_path' => $path, 'original_name' => $filename, 'mime_type' => $file->getClientMimeType(), 'size' => $file->getSize()];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function useCreate(User $user, string $path, string $usage = 'other',  ?string $fileableType = null, ?string $fileableId = null, string $visibility = 'private')
    {
        $file = self::where('user_id', $user->id)->where('file_path', $path)->first();
        if (!$file) {
            throw new \Exception("File not found");
        }
        DB::beginTransaction();
        try {
            $newPath = $usage . '/' . $user->id . '/' . strtotime(now()) . '_' . Str::random(16);
            Storage::disk($file->storage_disk)->move($path, $newPath);
            $file->file_path = $newPath;
            $file->usage = $usage;
            $file->visibility = $visibility;
            $file->fileable_id = $fileableId;
            $file->fileable_type = $fileableType;
            $file->save();
            DB::commit();
            return $file;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
