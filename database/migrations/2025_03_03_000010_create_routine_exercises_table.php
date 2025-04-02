<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routine_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rutina_id')->constrained('routines')->onDelete('cascade');
            $table->foreignId('ejercicio_id')->constrained('exercises')->onDelete('cascade');
            $table->enum('dia_semana', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']);
            $table->integer('orden');
            $table->timestamps();

            // Asegurar que un ejercicio no aparezca más de una vez en el mismo día de una rutina
            $table->unique(['rutina_id', 'ejercicio_id', 'dia_semana']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routine_exercises');
    }
};
