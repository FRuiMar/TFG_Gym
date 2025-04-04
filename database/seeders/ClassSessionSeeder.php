<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassSession;
use App\Models\Activity;

class ClassSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1. ZUMBA con Pepe (trainer_id: 3)
        // Horario de mañana: 10:00 - 11:00
        ClassSession::create([
            'activity_id' => 1, // Zumba
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Lunes',
            'hora_inicio' => '10:00:00',
            'hora_fin' => '11:00:00',
            'capacidad_max' => 20,
            'sala' => 'Sala 1',
            'notes' => 'Traer toalla y agua',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 1, // Zumba
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '10:00:00',
            'hora_fin' => '11:00:00',
            'capacidad_max' => 20,
            'sala' => 'Sala 1',
            'notes' => 'Traer toalla y agua',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 1, // Zumba
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Viernes',
            'hora_inicio' => '10:00:00',
            'hora_fin' => '11:00:00',
            'capacidad_max' => 20,
            'sala' => 'Sala 1',
            'notes' => 'Traer toalla y agua',
            'is_active' => true,
        ]);

        // Horario de tarde: 18:00 - 19:00
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


        // 2. YOGA con Rafa (trainer_id: 5)
        // Horario de mañana: 09:00 - 10:00
        ClassSession::create([
            'activity_id' => 2, // Yoga
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Martes',
            'hora_inicio' => '09:00:00',
            'hora_fin' => '10:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Traer esterilla y ropa cómoda',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 2, // Yoga
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Jueves',
            'hora_inicio' => '09:00:00',
            'hora_fin' => '10:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Traer esterilla y ropa cómoda',
            'is_active' => true,
        ]);

        // Horario de tarde: 17:30 - 18:30
        ClassSession::create([
            'activity_id' => 2, // Yoga
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Martes',
            'hora_inicio' => '17:30:00',
            'hora_fin' => '18:30:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Traer esterilla y ropa cómoda',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 2, // Yoga
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Jueves',
            'hora_inicio' => '17:30:00',
            'hora_fin' => '18:30:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Traer esterilla y ropa cómoda',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 2, // Yoga
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Viernes',
            'hora_inicio' => '17:30:00',
            'hora_fin' => '18:30:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Traer esterilla y ropa cómoda',
            'is_active' => true,
        ]);

        // 3. CROSSFIT con Fali (trainer_id: 4)
        // Horario de mañana: 11:30 - 12:30
        ClassSession::create([
            'activity_id' => 3, // Crossfit
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Lunes',
            'hora_inicio' => '11:30:00',
            'hora_fin' => '12:30:00',
            'capacidad_max' => 12,
            'sala' => 'Sala 3',
            'notes' => 'Nivel avanzado',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 3, // Crossfit
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '11:30:00',
            'hora_fin' => '12:30:00',
            'capacidad_max' => 12,
            'sala' => 'Sala 3',
            'notes' => 'Nivel avanzado',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 3, // Crossfit
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Viernes',
            'hora_inicio' => '11:30:00',
            'hora_fin' => '12:30:00',
            'capacidad_max' => 12,
            'sala' => 'Sala 3',
            'notes' => 'Nivel avanzado',
            'is_active' => true,
        ]);

        // Horario de tarde: 19:30 - 20:30
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

        // 4. HIIT con Manolo (trainer_id: 6)
        // Horario de mañana: 08:00 - 08:45
        ClassSession::create([
            'activity_id' => 4, // HIIT
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Martes',
            'hora_inicio' => '08:00:00',
            'hora_fin' => '08:45:00',
            'capacidad_max' => 18,
            'sala' => 'Sala 1',
            'notes' => 'Alta intensidad',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 4, // HIIT
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Jueves',
            'hora_inicio' => '08:00:00',
            'hora_fin' => '08:45:00',
            'capacidad_max' => 18,
            'sala' => 'Sala 1',
            'notes' => 'Alta intensidad',
            'is_active' => true,
        ]);

        // Horario de tarde: 19:30 - 20:15
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

        ClassSession::create([
            'activity_id' => 4, // HIIT
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Viernes',
            'hora_inicio' => '19:30:00',
            'hora_fin' => '20:15:00',
            'capacidad_max' => 18,
            'sala' => 'Sala 1',
            'notes' => 'Alta intensidad',
            'is_active' => true,
        ]);

        // 5. PILATES con Manolo (trainer_id: 6)
        // Horario de mañana: 10:00 - 11:00
        ClassSession::create([
            'activity_id' => 5, // Pilates
            'trainer_id' => 6, // Manolo (según UserSeeder actualizado)
            'dia_semana' => 'Lunes',
            'hora_inicio' => '10:00:00',
            'hora_fin' => '11:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Todos los niveles, traer esterilla',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 5, // Pilates
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '10:00:00',
            'hora_fin' => '11:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Todos los niveles, traer esterilla',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 5, // Pilates
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Viernes',
            'hora_inicio' => '10:00:00',
            'hora_fin' => '11:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Todos los niveles, traer esterilla',
            'is_active' => true,
        ]);

        // Horario de tarde: 16:00 - 17:00
        ClassSession::create([
            'activity_id' => 5, // Pilates
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Lunes',
            'hora_inicio' => '16:00:00',
            'hora_fin' => '17:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Pilates vespertino, todos los niveles',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 5, // Pilates
            'trainer_id' => 6, // Manolo
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '16:00:00',
            'hora_fin' => '17:00:00',
            'capacidad_max' => 15,
            'sala' => 'Sala 2',
            'notes' => 'Pilates vespertino',
            'is_active' => true,
        ]);

        // 6. SPINNING con Fali (trainer_id: 4)
        // Horario de mañana: 07:30 - 08:15
        ClassSession::create([
            'activity_id' => 6, // Spinning
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Martes',
            'hora_inicio' => '07:30:00',
            'hora_fin' => '08:15:00',
            'capacidad_max' => 20,
            'sala' => 'Sala Cycling',
            'notes' => 'Traer toalla y botella de agua',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 6, // Spinning
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Jueves',
            'hora_inicio' => '07:30:00',
            'hora_fin' => '08:15:00',
            'capacidad_max' => 20,
            'sala' => 'Sala Cycling',
            'notes' => 'Traer toalla y botella de agua',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 6, // Spinning
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Viernes',
            'hora_inicio' => '07:30:00',
            'hora_fin' => '08:15:00',
            'capacidad_max' => 20,
            'sala' => 'Sala Cycling',
            'notes' => 'Spinning matutino',
            'is_active' => true,
        ]);

        // Horario de tarde: 19:00 - 19:45
        ClassSession::create([
            'activity_id' => 6, // Spinning
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Lunes',
            'hora_inicio' => '19:00:00',
            'hora_fin' => '19:45:00',
            'capacidad_max' => 20,
            'sala' => 'Sala Cycling',
            'notes' => 'Spinning vespertino',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 6, // Spinning
            'trainer_id' => 4, // Fali
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '19:00:00',
            'hora_fin' => '19:45:00',
            'capacidad_max' => 20,
            'sala' => 'Sala Cycling',
            'notes' => 'Spinning vespertino',
            'is_active' => true,
        ]);

        // 7. BOXEO con Pepe (trainer_id: 3)
        // Horario de mañana: 08:30 - 09:30
        ClassSession::create([
            'activity_id' => 7, // Boxeo
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Martes',
            'hora_inicio' => '08:30:00',
            'hora_fin' => '09:30:00',
            'capacidad_max' => 12,
            'sala' => 'Sala de Combate',
            'notes' => 'Boxeo matutino, nivel principiante',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 7, // Boxeo
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Jueves',
            'hora_inicio' => '08:30:00',
            'hora_fin' => '09:30:00',
            'capacidad_max' => 12,
            'sala' => 'Sala de Combate',
            'notes' => 'Boxeo matutino, nivel principiante',
            'is_active' => true,
        ]);

        // Horario de tarde: 20:00 - 21:00
        ClassSession::create([
            'activity_id' => 7, // Boxeo
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Lunes',
            'hora_inicio' => '20:00:00',
            'hora_fin' => '21:00:00',
            'capacidad_max' => 12,
            'sala' => 'Sala de Combate',
            'notes' => 'Se proporcionan guantes, traer vendas',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 7, // Boxeo
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Miércoles',
            'hora_inicio' => '20:00:00',
            'hora_fin' => '21:00:00',
            'capacidad_max' => 12,
            'sala' => 'Sala de Combate',
            'notes' => 'Se proporcionan guantes, traer vendas',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 7, // Boxeo
            'trainer_id' => 3, // Pepe
            'dia_semana' => 'Viernes',
            'hora_inicio' => '20:00:00',
            'hora_fin' => '21:00:00',
            'capacidad_max' => 8,
            'sala' => 'Sala de Combate',
            'notes' => 'Clase avanzada con sparring, equipo completo necesario',
            'is_active' => true,
        ]);

        // 8. SALSA con Rafa (trainer_id: 5)
        // Horario de mañana: 11:30 - 12:30
        ClassSession::create([
            'activity_id' => 8, // Salsa
            'trainer_id' => 5, // Rafa (según UserSeeder actualizado)
            'dia_semana' => 'Martes',
            'hora_inicio' => '11:30:00',
            'hora_fin' => '12:30:00',
            'capacidad_max' => 24,
            'sala' => 'Sala 1',
            'notes' => 'No necesitas pareja, traer calzado adecuado',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 8, // Salsa
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Jueves',
            'hora_inicio' => '11:30:00',
            'hora_fin' => '12:30:00',
            'capacidad_max' => 24,
            'sala' => 'Sala 1',
            'notes' => 'No necesitas pareja, traer calzado adecuado',
            'is_active' => true,
        ]);

        // Horario de tarde: 20:30 - 21:30
        ClassSession::create([
            'activity_id' => 8, // Salsa
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Martes',
            'hora_inicio' => '20:30:00',
            'hora_fin' => '21:30:00',
            'capacidad_max' => 24,
            'sala' => 'Sala 1',
            'notes' => 'No necesitas pareja, traer calzado adecuado',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 8, // Salsa
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Jueves',
            'hora_inicio' => '20:30:00',
            'hora_fin' => '21:30:00',
            'capacidad_max' => 24,
            'sala' => 'Sala 1',
            'notes' => 'No necesitas pareja, traer calzado adecuado',
            'is_active' => true,
        ]);

        ClassSession::create([
            'activity_id' => 8, // Salsa
            'trainer_id' => 5, // Rafa
            'dia_semana' => 'Viernes',
            'hora_inicio' => '20:30:00',
            'hora_fin' => '21:30:00',
            'capacidad_max' => 30,
            'sala' => 'Sala 1',
            'notes' => 'Salsa y bachata, fiesta de baile',
            'is_active' => true,
        ]);
    }
}
