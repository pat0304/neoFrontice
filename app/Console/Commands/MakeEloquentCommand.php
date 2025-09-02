<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeEloquentCommand extends Command
{
    protected $signature = 'make:eloquent {name}';
    protected $description = 'create a new Eloquent Interface';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Eloquents/{$name}Eloquent.php");

        if (!File::isDirectory(app_path('Eloquents'))) {
            File::makeDirectory(app_path('Eloquents'));
        }

        if (File::exists($path)) {
            $this->error("File {$name}Eloquent.php đã tồn tại!");
            return;
        }

        $stub = <<<EOT
<?php

namespace App\Eloquents;

interface {$name}Eloquent
{
    //
}
EOT;

        File::put($path, $stub);

        $this->info("{$name}Eloquent đã được tạo tại app/Eloquent/{$name}Eloquent.php");
    }
}
