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
        $upload = File::upload($file);
        return $upload;
    }
    public function createFile(User $user, string $path, string $usage = 'other',  string $fileableType = null, string $fileableId = null, string $visibility = 'private')
    {
        $file = File::useCreate($user, $path, $usage, $fileableType, $fileableId, $visibility);
        return $file;
    }
}
