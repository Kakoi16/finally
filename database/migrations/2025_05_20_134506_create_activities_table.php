<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_activities_table.php
public function up()
{
    Schema::create('activities', function (Blueprint $table) {
        $table->id();
        $table->uuid('user_id');
        $table->string('activity'); // deskripsi aktivitas
        $table->string('url')->nullable(); // URL halaman jika ingin ditampilkan
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
