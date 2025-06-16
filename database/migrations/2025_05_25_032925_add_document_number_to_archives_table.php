<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->string('document_number')->nullable()->after('type'); // Sesuaikan 'after' jika perlu
        });
    }

    public function down()
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->dropColumn('document_number');
        });
    }
};