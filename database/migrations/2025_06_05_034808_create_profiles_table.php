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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id(); // Primary key untuk tabel profiles

            // Foreign key untuk menghubungkan ke tabel users
            // Asumsikan 'id' di tabel 'users' adalah char(36) atau UUID
            $table->uuid('user_id')->unique(); // unique() untuk memastikan relasi one-to-one
            // Jika 'id' di tabel 'users' adalah BIGINT auto-increment, gunakan:
            // $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            // Tambahkan kolom-kolom spesifik untuk profil
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_picture_path')->nullable(); // Path ke gambar profil
            // Tambahkan kolom lain sesuai kebutuhan Anda
            // $table->string('website')->nullable();
            // $table->date('date_of_birth')->nullable();

            $table->timestamps(); // created_at dan updated_at

            // Mendefinisikan foreign key constraint secara eksplisit jika menggunakan UUID
            // Sesuaikan 'users' dan 'id' jika nama tabel atau primary key users berbeda
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Jika user dihapus, profilnya juga ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};