<?php

namespace App\Services\File;

use App\Eloquents\FileEloquent;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService implements FileEloquent
{
    public function uploadFile($file)
    {
        $filename = $file->getClientOriginalName();
        $path = 'temp/' . auth()->guard()->user()->id . strtotime(now()) . '_' . Str::random(16);
        $storage_disk = 's3';
        DB::beginTransaction();
        try {
            $success = false;
            // $success = Storage::disk('s3')->put($path, file_get_contents($file));
            if (!$success) {
                $storage_disk = 'gcs';
                $firebaseStorage = Storage::disk('gcs')->put($path, file_get_contents($file));
                if (!$firebaseStorage) {
                    throw new \Exception("Upload failed: return false");
                }
            }
            $fileModel = File::create([
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
    public function createFile(User $user, string $path, string $usage = 'other',  string $fileableType = null, string $fileableId = null, string $visibility = 'private')
    {
        $file = File::where('user_id', $user->id)->where('file_path', $path)->first();
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
