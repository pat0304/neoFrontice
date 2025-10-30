<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Level::count() == 0) {
            $levels = [
                [
                    'name' => 'Bronze',
                    'default_points' => 15,
                    'required_points' => 0,
                ],
                [
                    'name' => 'Silver',
                    'default_points' => 25,
                    'required_points' => 50,
                ],
                [
                    'name' => 'Gold',
                    'default_points' => 50,
                    'required_points' => 150,
                ],
                [
                    'name' => 'Platinum',
                    'default_points' => 75,
                    'required_points' => 250,
                ],
                [
                    'name' => 'Diamond',
                    'default_points' => 100,
                    'required_points' => 500,
                ]
            ];
            foreach ($levels as $level) {
                Level::create($level);
            }
        }
    }
}
