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
        Schema::create('university_filials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_university_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('top_university_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('filial_name')->nullable();
            $table->string('city');
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_filials');
    }
};