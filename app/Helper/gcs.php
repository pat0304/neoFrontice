<?php

use Google\Cloud\Storage\StorageClient;

if (! function_exists('gcs_temporary_url')) {
    /**
     * Generate a signed temporary URL for a GCS object.
     *
     * @param string $path        Đường dẫn file trong bucket (ví dụ: avatars/a.png)
     * @param int    $minutes     Số phút hết hạn
     * @param array  $options     Tuỳ chọn thêm cho signedUrl
     *
     * @return string
     */
    function gcs_temporary_url(string $path, int $minutes = 15, array $options = []): string
    {
        $storage = new StorageClient([
            'projectId'   => env('GCS_PROJECT_ID'),
            'keyFilePath' => env('GCS_KEY_FILE'),
        ]);

        $bucket = $storage->bucket(env('GCS_BUCKET'));
        $object = $bucket->object($path);

        return $object->signedUrl(
            new \DateTime("+{$minutes} minutes"),
            array_merge(['version' => 'v4'], $options)
        );
    }
}
