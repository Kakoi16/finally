<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('archive_user', function (Blueprint $table) {
    $table->char('archive_id', 36);
    $table->char('user_id', 36);

    $table->primary(['archive_id', 'user_id']);

    $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

});

    }

    public function down(): void
    {
        Schema::dropIfExists('archive_user');
    }
};
