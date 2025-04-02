<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 10)->unique();
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('surname2', 50)->nullable(); // Apellido 2 (puede ser nulo)
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['NORMAL', 'ADMIN', 'TRAINER'])->default('NORMAL'); // Rol (enum)
            $table->enum('sexo', ['H', 'M', 'NC'])->default('NC'); // Sexo (Hombre, Mujer, No especificado)
            $table->decimal('weight', 5, 2)->nullable(); // Peso en kg (hasta 999.99)
            $table->decimal('height', 3, 2)->nullable(); // Altura en metros (hasta 9.99)
            $table->date('birth_date')->nullable(); // Fecha de nacimiento (puede ser nula)
            $table->string('phone', 15)->nullable(); // Teléfono de contacto
            $table->string('emergency_contact', 100)->nullable(); // Contacto de emergencia
            $table->text('health_conditions')->nullable(); // Condiciones médicas relevantes
            $table->string('specialty_1', 50)->nullable(); // Especialidad principal como texto
            $table->string('specialty_2', 50)->nullable(); // Especialidad secundaria como texto 
            $table->boolean('notifications_enabled')->default(true); // Preferencia de recibir notificaciones
            $table->string('image')->nullable(); // Imagen (puede ser nula)
            $table->foreignId('membership_id')->nullable()->constrained('memberships')->onDelete('set null'); // Relación con membresías
            $table->boolean('active')->default(true); // Estado activo/inactivo
            $table->rememberToken(); // Token para "recordar" sesión
            $table->timestamps(); // created_at y updated_at
            $table->softDeletes(); // deleted_at para soft delete
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
