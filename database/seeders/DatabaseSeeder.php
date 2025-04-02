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


        // Ejecutar el MembershipSeeder primero.
        $this->call([
            MembershipSeeder::class,
            MembershipBenefitSeeder::class,
        ]);


        // Luego ejecutar el ActivitySeeder
        $this->call([
            ActivitySeeder::class,
        ]);


        // Luego ejecutar el UserSeeder
        $this->call([
            UserSeeder::class,
        ]);

        // Finalmente sesiones (que dependen de actividades y usuarios/entrenadores)
        $this->call([
            ClassSessionSeeder::class,
        ]);
    }
}
