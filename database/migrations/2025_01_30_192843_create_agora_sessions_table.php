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
        Schema::create('agora_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('theme', 300);
            $table->string('lieu');
            $table->text('description')->nullable();
            $table->integer('places');
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin')->nullable();
            $table->string('presentateur')->nullable();
            $table->foreignId('presentateur_id')->nullable()->constrained(table: "users")->cascadeOnUpdate()->nullOnDelete();
            $table->string('image')->nullable();
            $table->boolean('published')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agora_sessions');
    }
};
