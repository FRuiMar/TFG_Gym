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
            'dni' => '11111111A', // DNI único
            'name' => 'Admin User',
            'email' => 'f@f.com',
            'password' => Hash::make('12345'), // Contraseña fija: 12345
            'role' => 'ADMIN', // Rol de administrador
            'image' => null, // Sin imagen
            'membership_id' => 1,
        ]);

        // Crear un usuario normal
        User::create([
            'dni' => '22222222B', // DNI único
            'name' => 'Normal User',
            'email' => 'f2@f.com',
            'password' => Hash::make('12345'), // Contraseña fija: 12345
            'role' => 'NORMAL', // Rol normal
            'image' => null, // Sin imagen
            'membership_id' => 2,
        ]);

        // Crear 10 usuarios de prueba usando el factory
        User::factory()->count(10)->create();
    }
}
