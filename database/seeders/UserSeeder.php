<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario administrador
        User::create([
            'dni' => '11111111A',
            'name' => 'Admin',
            'surname' => 'System',
            'surname2' => null,
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'ADMIN',
            'sexo' => 'NC',
            'weight' => null,
            'height' => null,
            'birth_date' => null,
            'phone' => '600111222',
            'emergency_contact' => null,
            'health_conditions' => null,
            'specialty_1_id' => null,
            'specialty_2_id' => null,
            'notifications_enabled' => true,
            'image' => null,
            'membership_id' => null,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        // Crear un usuario normal
        User::create([
            'dni' => '22222222B',
            'name' => 'Usuario',
            'surname' => 'Normal',
            'surname2' => 'Prueba',
            'email' => 'user@user.com',
            'password' => Hash::make('12345678'),
            'role' => 'NORMAL',
            'sexo' => 'H',
            'weight' => 75.5,
            'height' => 1.80,
            'birth_date' => '1990-05-15',
            'phone' => '600333444',
            'emergency_contact' => 'Familiar: 600555666',
            'health_conditions' => 'Ninguna',
            'specialty_1_id' => null,
            'specialty_2_id' => null,
            'notifications_enabled' => true,
            'image' => null,
            'membership_id' => 1, // ID de una membresía básica
            'active' => true,
            'email_verified_at' => now(),
        ]);





        // Crear entrenadores (antes en TrainerSeeder)
        // Por orden de creación serán id 3, 4, 5, 6
        User::create([
            'dni' => '12312312A',
            'name' => 'Pepe',
            'surname' => 'Powers',
            'surname2' => null,
            'email' => 'pepe@forza.com',
            'password' => Hash::make('12345678'), // Cambié por la misma contraseña que los otros
            'role' => 'TRAINER',
            'sexo' => 'H',
            'weight' => 85.0,
            'height' => 1.85,
            'birth_date' => '1985-02-10',
            'phone' => '600123456',
            'emergency_contact' => 'Familiar: 600789012',
            'health_conditions' => null,
            'specialty_1_id' => 1, //Zumba
            'specialty_2_id' => 7, //Boxeo
            'notifications_enabled' => true,
            'image' => null,
            'membership_id' => null,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'dni' => '12121212A',
            'name' => 'Fali',
            'surname' => 'Fortachon',
            'surname2' => null,
            'email' => 'fali@forza.com',
            'password' => Hash::make('12345678'), // Cambié por la misma contraseña que los otros
            'role' => 'TRAINER',
            'sexo' => 'H',
            'weight' => 90.0,
            'height' => 1.90,
            'birth_date' => '1988-06-15',
            'phone' => '600234567',
            'emergency_contact' => null,
            'health_conditions' => null,
            'specialty_1_id' => 3, //Crossfit
            'specialty_2_id' => 6, //Spinning
            'notifications_enabled' => true,
            'image' => null,
            'membership_id' => null,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'dni' => '13131313A',
            'name' => 'Rafa',
            'surname' => 'Rapid',
            'surname2' => null,
            'email' => 'rafa@forza.com',
            'password' => Hash::make('12345678'), // Cambié por la misma contraseña que los otros
            'role' => 'TRAINER',
            'sexo' => 'H',
            'weight' => 75.0,
            'height' => 1.78,
            'birth_date' => '1990-11-22',
            'phone' => '600345678',
            'emergency_contact' => null,
            'health_conditions' => null,
            'specialty_1_id' => 2, //Yoga
            'specialty_2_id' => 8, //Salsa
            'notifications_enabled' => true,
            'image' => null,
            'membership_id' => null,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'dni' => '14141414A',
            'name' => 'Manolo',
            'surname' => 'McGym',
            'surname2' => null,
            'email' => 'manolo@forza.com',
            'password' => Hash::make('12345678'), // Cambié por la misma contraseña que los otros
            'role' => 'TRAINER',
            'sexo' => 'H',
            'weight' => 82.0,
            'height' => 1.82,
            'birth_date' => '1983-04-30',
            'phone' => '600456789',
            'emergency_contact' => null,
            'health_conditions' => null,
            'specialty_1_id' => 4, //HIIT
            'specialty_2_id' => 5, //Pilates
            'notifications_enabled' => true,
            'image' => null,
            'membership_id' => null,
            'active' => true,
            'email_verified_at' => now(),
        ]);




        // Crear 10 usuarios de prueba usando el factory
        User::factory()->count(10)->create();
    }
}
