<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassSession;

class ClassSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Zumba con Pepe (trainer_id: 5)
        ClassSession::create([
            'activity_id' => 1, // Zumba
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Lunes',
            'hora_inicio' => '18:00:00',
            'hora_fin' => '19:00:00',
            'capacidad_max' => 20,
            'sala' => 'Sala 1',
            'notes' => 'Traer toalla y agua',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 1, // Zumba
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '18:00:00',
            'hora_fin' => '19:00:00',
            'capacidad_max' => 20,
            'sala' => 'Sala 1',
            'notes' => 'Traer toalla y agua',
            'is_active' => true,
        ]);

        // Yoga con Rafa (trainer_id: 7)
        ClassSession::create([
            'activity_id' => 2, // Yoga
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Martes',
            'hora_inicio' => '18:00:00',
            'hora_fin' => '19:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Traer esterilla y ropa cómoda',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 2, // Yoga
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Jueves',
            'hora_inicio' => '18:00:00',
            'hora_fin' => '19:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Traer esterilla y ropa cómoda',
            'is_active' => true,
        ]);

        // Crossfit con Fali (trainer_id: 6)
        ClassSession::create([
            'activity_id' => 3, // Crossfit
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Lunes',
            'hora_inicio' => '19:30:00',
            'hora_fin' => '20:30:00',
            'capacidad_max' => 12,
            'sala' => 'Sala 3',
            'notes' => 'Nivel avanzado',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 3, // Crossfit
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '19:30:00',
            'hora_fin' => '20:30:00',
            'capacidad_max' => 12,
            'sala' => 'Sala 3',
            'notes' => 'Nivel avanzado',
            'is_active' => true,
        ]);

        // HIIT con Manolo (trainer_id: 8)
        ClassSession::create([
            'activity_id' => 4, // HIIT
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Martes',
            'hora_inicio' => '19:30:00',
            'hora_fin' => '20:15:00',
            'capacidad_max' => 18,
            'sala' => 'Sala 1',
            'notes' => 'Alta intensidad',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 4, // HIIT
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Jueves',
            'hora_inicio' => '19:30:00',
            'hora_fin' => '20:15:00',
            'capacidad_max' => 18,
            'sala' => 'Sala 1',
            'notes' => 'Alta intensidad',
            'is_active' => true,
        ]);
    }
}
