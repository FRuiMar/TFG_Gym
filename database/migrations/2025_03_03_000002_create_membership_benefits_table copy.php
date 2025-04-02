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
        Schema::create('membership_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->string('benefit_type', 50); // categoría del beneficio
            $table->string('name', 100);
            $table->string('value')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_benefits');
    }
};
