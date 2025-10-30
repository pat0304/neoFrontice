<?php

namespace Database\Seeders;

use App\Models\Technical;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Storage;

class TechnicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Technical::count() == 0) {
            $technicals = [
                ['name' => 'HTML', 'color' => '#E65100', 'file' => 'html.svg'],
                ['name' => 'CSS',  'color' => '#0277BD', 'file' => 'css.svg'],
                ['name' => 'JavaScript', 'color' => '#FDD835', 'file' => 'js.svg']
            ];
            foreach ($technicals as $tech) {
                $sourcePath = resource_path("icons/{$tech['file']}");
                $desPath = "icons/{$tech['file']}";
                if (!File::exists($sourcePath)) {
                    dump("⚠️ File not found: {$sourcePath}");
                    continue;
                }
                Storage::disk('public')->put($desPath, File::get($sourcePath));
                Technical::create([
                    "name" => $tech['name'],
                    "icon" => $desPath,
                    'color' => $tech['color']
                ]);
            }
            dump('✅ Technical icons seeded successfully.');
        }
    }
}
