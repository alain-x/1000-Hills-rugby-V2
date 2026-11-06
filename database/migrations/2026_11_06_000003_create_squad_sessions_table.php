<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('squad_sessions')) {
        Schema::create('squad_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('session_type', 20);
            $table->string('focus', 30)->nullable();
            $table->dateTime('starts_at');
            $table->unsignedSmallInteger('duration_minutes')->default(90);
            $table->string('location')->nullable();
            $table->string('intensity', 10)->default('medium');
            $table->string('opponent')->nullable();
            $table->string('status', 20)->default('scheduled');
            $table->text('plan')->nullable();
            $table->timestamps();

            $table->index(['team_id', 'starts_at']);
        });
        }

        Schema::table('player_attendances', function (Blueprint $table) {
            $table->index('player_id', 'player_attendances_player_id_index');
            $table->dropUnique('player_session_unique');
            $table->foreignId('session_id')->nullable()->after('id')->constrained('squad_sessions')->cascadeOnDelete();
            $table->unsignedSmallInteger('minutes')->nullable()->after('status');
            $table->unsignedTinyInteger('rpe')->nullable()->after('minutes');
            $table->unique(['session_id', 'player_id']);
        });
    }

    public function down(): void
    {
        Schema::table('player_attendances', function (Blueprint $table) {
            $table->dropUnique(['session_id', 'player_id']);
            $table->dropConstrainedForeignId('session_id');
            $table->dropColumn(['minutes', 'rpe']);
            $table->unique(['player_id', 'session_date', 'session_type'], 'player_session_unique');
        });

        Schema::dropIfExists('squad_sessions');
    }
};
