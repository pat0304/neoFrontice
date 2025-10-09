<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeRouteCommand extends Command
{
    // Đặt lại signature
    protected $signature = 'make:route {path}';
    protected $description = 'Tạo file route API trong routes/api với folder tự động';

    public function handle()
    {
        $path = $this->argument('path');

        // ví dụ: v1/Client/User/UserController
        $segments = explode('/', $path);
        $controller = array_pop($segments); // UserController
        $folderPath = base_path('routes/api/' . implode('/', $segments));

        // Tên file route = User.php
        $fileName = Str::replaceLast('Controller', '', class_basename($controller)) . '.php';
        $filePath = $folderPath . '/' . $fileName;

        // Tạo folder nếu chưa có
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
            $this->info("Đã tạo folder: $folderPath");
        }

        // Nội dung route mặc định
        $content = <<<PHP
        <?php

        use Illuminate\\Support\\Facades\\Route;

        Route::prefix("__PREFIX__")->middleware([__MIDDLEWARE__])->group(function () {
        });
        PHP;

        // Ghi file
        file_put_contents($filePath, $content);

        $this->info("✅ Đã tạo route file: $filePath");
        return Command::SUCCESS;
    }
}
