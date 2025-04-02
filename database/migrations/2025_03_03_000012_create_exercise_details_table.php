<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercise_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('ejercicio_id')->constrained('exercises')->onDelete('cascade');
            $table->integer('orden');
            $table->text('notas')->nullable();

            // Un ejercicio solo puede aparecer una vez en una misma sesión
            $table->unique(['workout_session_id', 'ejercicio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise_details');
    }
};
