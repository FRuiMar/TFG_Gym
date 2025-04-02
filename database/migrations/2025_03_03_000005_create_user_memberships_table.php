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
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_id')->constrained()->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('payment_status', ['pending', 'paid', 'cancelled', 'refunded'])->default('pending');
            $table->timestamp('last_payment_date')->nullable();
            $table->timestamp('next_payment_date')->nullable();
            $table->decimal('amount_paid', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_memberships');
    }
};
