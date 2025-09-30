<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteTempFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-temp-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = File::where('usage', 'temp')->where('created_at', '<', now()->subDay())->chunkById(100, function ($files) {
            foreach ($files as $file) {
                DB::beginTransaction();
                try {
                    Storage::disk($file->storage_disk)->delete($file->file_path);
                    $file->delete();
                    DB::commit();
                } catch (\Throwable $th) {
                    $this->error($th->getMessage());
                    DB::rollBack();
                }
            }
        });
        // if ($files->count() > 0) {
        //     foreach ($files->get() as $file) {
        //         DB::beginTransaction();
        //         try {
        //             Storage::disk('s3')->delete($file->file_path);
        //             $file->delete();
        //             DB::commit();
        //         } catch (\Throwable $th) {
        //             $this->error($th->getMessage());
        //             DB::rollBack();
        //         }
        //     }
        //     $this->info('Temporary files deleted successfully.');
        // }
        return 0;
    }
}
