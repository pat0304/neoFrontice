<?php

namespace App\Eloquents;

use App\Models\User;

interface FileEloquent
{
    public function uploadFile($file);
    public function createFile(User $user, string $path, string $usage = 'other',  string $fileableType = null, string $fileableId = null, string $visibility = 'private');
}
