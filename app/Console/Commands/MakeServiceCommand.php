<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');

        // Chuẩn hóa tên class (loại bỏ .php nếu có)
        $name = str_replace('.php', '', $name);

        // Tên class (không bao gồm folder)
        $className = class_basename($name);

        // Đường dẫn đầy đủ đến file Service
        $path = app_path('Services/' . str_replace('\\', '/', $name) . '.php');

        // Đảm bảo thư mục tồn tại
        File::ensureDirectoryExists(dirname($path));

        // Kiểm tra nếu file đã tồn tại
        if (File::exists($path)) {
            $this->error("Service {$name} đã tồn tại!");
            return;
        }

        // Namespace chính xác (ví dụ: App\Services\Foo)
        $subNamespace = trim(Str::replaceLast($className, '', str_replace('/', '\\', $name)), '\\');
        $namespace = 'App\\Services' . ($subNamespace ? '\\' . $subNamespace : '');

        $content = <<<PHP
<?php

namespace {$namespace};

class {$className}
{
    //
}
PHP;

        File::put($path, $content);

        $this->info("Service [{$name}] created successfully.");
    }
}
