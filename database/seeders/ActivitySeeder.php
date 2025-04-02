<?php

namespace Database\Seeders;

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
            'nombre' => 'Zumba',
            'descripcion' => 'Baile fitness de alta energía inspirado en ritmos latinos.',
            'duracion_minutos' => 60,
            'nivel_dificultad' => 'medio',
            'imagen' => null,
            'calories_burned' => 600,
            'active' => true,
        ]);

        Activity::create([
            'id' => 2,
            'nombre' => 'Yoga',
            'descripcion' => 'Práctica que conecta el cuerpo, la respiración y la mente para mejorar la salud física y mental.',
            'duracion_minutos' => 60,
            'nivel_dificultad' => 'bajo',
            'imagen' => null,
            'calories_burned' => 300,
            'active' => true,
        ]);

        Activity::create([
            'id' => 3,
            'nombre' => 'Crossfit',
            'descripcion' => 'Entrenamiento de alta intensidad que combina movimientos funcionales de diferentes disciplinas.',
            'duracion_minutos' => 60,
            'nivel_dificultad' => 'alto',
            'imagen' => null,
            'calories_burned' => 800,
            'active' => true,
        ]);

        Activity::create([
            'id' => 4,
            'nombre' => 'HIIT',
            'descripcion' => 'Entrenamiento intervalado de alta intensidad que alterna periodos cortos de ejercicio intenso con periodos de recuperación.',
            'duracion_minutos' => 45,
            'nivel_dificultad' => 'alto',
            'imagen' => null,
            'calories_burned' => 700,
            'active' => true,
        ]);

        Activity::create([
            'id' => 5,
            'nombre' => 'Pilates',
            'descripcion' => 'Método de ejercicio físico y mental que se centra en el desarrollo de los músculos internos.',
            'duracion_minutos' => 50,
            'nivel_dificultad' => 'medio',
            'imagen' => null,
            'calories_burned' => 250,
            'active' => true,
        ]);

        Activity::create([
            'id' => 6,
            'nombre' => 'Spinning',
            'descripcion' => 'Clase de ciclismo indoor de alta energía y bajo impacto.',
            'duracion_minutos' => 45,
            'nivel_dificultad' => 'medio',
            'imagen' => null,
            'calories_burned' => 500,
            'active' => true,
        ]);

        Activity::create([
            'id' => 7,
            'nombre' => 'Boxeo',
            'descripcion' => 'Entrenamiento basado en técnicas de boxeo para mejorar la resistencia y fuerza.',
            'duracion_minutos' => 60,
            'nivel_dificultad' => 'alto',
            'imagen' => null,
            'calories_burned' => 700,
            'active' => true,
        ]);

        Activity::create([
            'id' => 8,
            'nombre' => 'Salsa',
            'descripcion' => 'Baile latino con ritmos caribeños para mejorar la coordinación y condición física.',
            'duracion_minutos' => 60,
            'nivel_dificultad' => 'medio',
            'imagen' => null,
            'calories_burned' => 400,
            'active' => true,
        ]);
    }
}
