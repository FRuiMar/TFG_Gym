<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performed_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalle_ejercicio_sesion_id')->constrained('exercise_details')->onDelete('cascade');
            $table->integer('numero_serie');
            $table->integer('repeticiones');
            $table->decimal('peso', 5, 2)->nullable();
            $table->integer('descanso_segundos')->nullable();

            // Una serie solo puede aparecer una vez para cada ejercicio
            $table->unique(['detalle_ejercicio_sesion_id', 'numero_serie']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performed_series');
    }
};
