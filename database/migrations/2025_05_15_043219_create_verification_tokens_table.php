<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('verification_tokens', function (Blueprint $table) {
    $table->char('id', 36)->primary(); // UUID manual
    $table->char('user_id', 36);
    $table->text('token');
    $table->dateTime('created_at');

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    public function down(): void {
        Schema::dropIfExists('verification_tokens');
    }
};
