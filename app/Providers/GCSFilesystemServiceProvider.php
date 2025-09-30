<?php

namespace App\Providers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Illuminate\Support\Str;

class GCSFilesystemServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Storage::extend('gcs', function ($app, $config) {
            $keyFilePath = $config['key_file_path'] ?? null;

            // Convert relative path -> absolute
            if (
                $keyFilePath && !Str::startsWith($keyFilePath, ['/', '\\'])
                && !preg_match('/^[A-Za-z]:\\\\/', $keyFilePath)
            ) {
                $keyFilePath = base_path($keyFilePath);
            }

            $client = new StorageClient([
                'projectId'   => $config['project_id'] ?? null,
                'keyFilePath' => $keyFilePath,
            ]);

            $bucket  = $client->bucket($config['bucket']);
            $adapter = new GoogleCloudStorageAdapter(
                $bucket,
                $config['path_prefix'] ?? ''
            );

            return new FilesystemAdapter(
                new Filesystem($adapter, [
                    'visibility' => $config['visibility'] ?? 'private',
                ]),
                $adapter,
                $config
            );
        });
    }
}
