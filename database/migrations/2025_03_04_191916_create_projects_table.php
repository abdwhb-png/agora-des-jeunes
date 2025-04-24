<?php

use App\Enums\ProjectStatus;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('type')->nullable(); // ex: 'entrepreneuriat', 'association', 'innovation sociale'
            $table->text('description')->nullable();
            $table->text('markdown')->nullable();
            $table->text('content')->nullable();
            $table->enum('status', array_map(fn($case) => $case->value, ProjectStatus::cases()))->default(ProjectStatus::ONGOING->value);
            $table->string('duration')->nullable();
            $table->string('location')->nullable();
            $table->string('team_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
