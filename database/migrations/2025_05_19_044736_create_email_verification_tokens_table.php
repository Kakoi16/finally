<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('email_verification_tokens', function (Blueprint $table) {
            $table->id();
            $table->char('user_id', 36);
            $table->string('token', 100)->unique();
            $table->timestamps();

            // Foreign key opsional (pastikan 'users.id' char(36))
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('email_verification_tokens');
    }
};
