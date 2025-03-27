<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::create([
            'id' => 1,
            'name' => 'Zumba',
            'schedule' => 'Lunes y Miércoles 18:00-19:00',
            'max_capacity' => 20,
            'trainer_id' => 1,
            'image' => null,
        ]);

        Activity::create([
            'id' => 2,
            'name' => 'Yoga',
            'schedule' => 'Martes y Jueves 18:00-19:00',
            'max_capacity' => 15,
            'trainer_id' => 2,
            'image' => null,
        ]);

        Activity::create([
            'id' => 3,
            'name' => 'Crossfit',
            'schedule' => 'Lunes y Miércoles 19:30-20:30',
            'max_capacity' => 12,
            'trainer_id' => 3,
            'image' => null,
        ]);

        Activity::create([
            'id' => 4,
            'name' => 'HIIT',
            'schedule' => 'Martes y Jueves 19:30-20:30',
            'max_capacity' => 18,
            'trainer_id' => 4,
            'image' => null,
        ]);
    }
}
