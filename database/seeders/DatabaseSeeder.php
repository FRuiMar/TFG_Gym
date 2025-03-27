<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Ejecutar el Trainer primero.
        $this->call([
            TrainerSeeder::class,
        ]);

        // Ejecutar el MembershipSeeder después.
        $this->call([
            MembershipSeeder::class,
        ]);


        // Luego ejecutar el UserSeeder
        $this->call([
            UserSeeder::class,
        ]);

        // Luego ejecutar el ActivitySeeder
        $this->call([
            ActivitySeeder::class,
        ]);
    }
}
