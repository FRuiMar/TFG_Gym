<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('categoria', 50)->nullable();
            $table->string('muscle_groups')->nullable();
            $table->string('equipment_needed')->nullable();
            $table->string('imagen')->nullable();
            $table->string('video_url')->nullable();
            $table->text('instrucciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
