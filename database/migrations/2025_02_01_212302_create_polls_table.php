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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Titre du sondage
            $table->text('description')->nullable(); // Description facultative
            $table->boolean('is_public')->default(true); // Public ou privé
            $table->boolean('show_options')->nullable(); // Public ou privé
            $table->dateTime('start_at')->nullable(); // Date de début
            $table->dateTime('end_at')->nullable(); // Date de fin
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
