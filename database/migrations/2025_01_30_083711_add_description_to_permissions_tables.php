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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('description', 500)->nullable();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->string('description', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('archived_at');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('archived_at');
        });
    }
};
