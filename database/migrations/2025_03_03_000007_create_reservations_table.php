<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('session_id')->constrained('class_sessions')->onDelete('cascade');
            $table->date('fecha');
            $table->enum('estado', ['confirmada', 'cancelada', 'asistida', 'no-show'])->default('confirmada');
            $table->time('check_in_time')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Asegurar que un usuario no tenga múltiples reservas para la misma sesión en la misma fecha
            $table->unique(['user_id', 'session_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
