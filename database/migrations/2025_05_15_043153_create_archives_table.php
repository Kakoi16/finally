<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('archives', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name');
            $table->string('path');
            $table->string('type');
            $table->integer('size');
            $table->string('uploaded_by')->nullable();
            $table->dateTime('created_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('archives');
    }
};
