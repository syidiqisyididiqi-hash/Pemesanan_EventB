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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description');
            $table->string('slug', 170)->unique();
            $table->dateTime('event_at');
            $table->string('location', 150);
            $table->unsignedInteger('quota');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
            $table->index('event_at');
            $table->index('status');

            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
