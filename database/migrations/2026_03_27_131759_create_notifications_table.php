<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ID user penerima notifikasi');
            $table->string('title', 100);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('user_id', 'fk_notifications_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};