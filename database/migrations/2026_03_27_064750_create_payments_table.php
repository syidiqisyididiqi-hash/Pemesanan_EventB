<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_code')->unique();
            $table->foreignId('booking_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method', 50);
            $table->timestamp('payment_date')->nullable();
            $table->enum('status', ['unpaid', 'paid', 'failed'])->default('unpaid');
            $table->index('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};