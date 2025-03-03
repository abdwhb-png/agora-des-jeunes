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
        Schema::create('cv_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained(table: 'cvs', column: 'id')->onDelete('cascade');
            $table->string('language')->default('french');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('summery')->nullable();
            $table->json('experiences')->nullable();
            $table->json('educations')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->json('interests')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_infos');
    }
};