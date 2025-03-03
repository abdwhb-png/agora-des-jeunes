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
        Schema::create('session_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agora_session_id')->constrained()->cascadeOnDelete();

            // Gestion des utilisateurs inscrits
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Gestion des votes anonymes
            $table->string('ip_address')->nullable(); // Stocker l'IP pour limiter les votes
            $table->string('session_id')->nullable(); // Gérer les votes via session

            $table->timestamps();

            // Un utilisateur (ou une IP) ne peut voter qu'une fois par session
            $table->unique(['agora_session_id', 'user_id', 'ip_address', 'session_id'], 'session_app_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_applications');
    }
};
