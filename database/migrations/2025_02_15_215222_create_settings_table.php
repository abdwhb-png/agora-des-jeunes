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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default(config('app.name'));
            $table->string('site_email')->nullable();
            $table->string('site_phone')->nullable();
            $table->string('site_address')->nullable();
            $table->string('help_availability')->nullable();
            $table->string('site_slogan')->nullable();
            $table->string('site_description', 500)->nullable();
            $table->text('site_keywords')->nullable();
            $table->string('contact_url')->nullable();
            $table->text('tcs_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};