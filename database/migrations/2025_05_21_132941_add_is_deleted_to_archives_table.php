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
    Schema::table('archives', function (Blueprint $table) {
        $table->boolean('is_deleted')->default(false);
        $table->timestamp('deleted_at')->nullable();
    });
}

public function down()
{
    Schema::table('archives', function (Blueprint $table) {
        $table->dropColumn(['is_deleted', 'deleted_at']);
    });
}

};
