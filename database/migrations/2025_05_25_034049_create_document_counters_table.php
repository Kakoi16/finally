<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_counters', function (Blueprint $table) {
            $table->string('counter_key')->primary(); // Kunci unik untuk setiap jenis nomor (misal: template_surat_2025)
            $table->integer('current_value')->default(0); // Nomor terakhir yang digunakan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_counters');
    }
};