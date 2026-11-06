<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('role')->constrained('teams')->nullOnDelete();
        });

        Schema::create('player_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coach_id')->constrained('users')->cascadeOnDelete();
            $table->date('session_date');
            $table->string('session_type', 20);
            $table->string('status', 20);
            $table->string('note')->nullable();
            $table->timestamps();

            $table->unique(['player_id', 'session_date', 'session_type'], 'player_session_unique');
        });

        Schema::create('player_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coach_id')->constrained('users')->cascadeOnDelete();
            $table->date('report_date');
            $table->unsignedTinyInteger('effort');
            $table->unsignedTinyInteger('skill');
            $table->unsignedTinyInteger('discipline');
            $table->unsignedTinyInteger('teamwork');
            $table->unsignedTinyInteger('fitness');
            $table->decimal('rating', 3, 1);
            $table->text('report');
            $table->timestamps();

            $table->index(['team_id', 'report_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_reports');
        Schema::dropIfExists('player_attendances');
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('team_id');
        });
    }
};
