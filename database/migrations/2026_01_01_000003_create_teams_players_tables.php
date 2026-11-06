<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Club squads (Men, Women, Academy age groups)
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('category')->default('men');
            $table->string('gender')->nullable();
            $table->string('age_group')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('coach')->nullable();
            $table->string('home_ground')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->string('team')->default('men');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('role')->nullable();
            $table->string('position_category')->nullable();
            $table->string('special_role')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->unsignedInteger('games')->default(0);
            $table->unsignedInteger('points')->default(0);
            $table->unsignedInteger('tries')->default(0);
            $table->string('place_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->text('honours')->nullable();
            $table->string('joined')->nullable();
            $table->text('previous_clubs')->nullable();
            $table->string('sponsor')->nullable();
            $table->text('sponsor_desc')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['team', 'is_published']);
        });

        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('tier')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('image')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Opponent / league clubs used on the standings table
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('league_standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            $table->foreignId('competition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->foreignId('gender_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('matches_played')->default(0);
            $table->unsignedInteger('matches_won')->default(0);
            $table->unsignedInteger('matches_drawn')->default(0);
            $table->unsignedInteger('matches_lost')->default(0);
            $table->integer('tries_for')->default(0);
            $table->integer('tries_against')->default(0);
            $table->integer('points_for')->default(0);
            $table->integer('points_against')->default(0);
            $table->integer('points_difference')->default(0);
            $table->integer('league_points')->default(0);
            $table->decimal('form_score', 3, 2)->default(0);
            $table->timestamps();

            $table->unique(['club_id', 'competition_id', 'season_id', 'gender_id'], 'unique_club_comp_season_gender');
        });

        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('home_team');
            $table->string('away_team');
            $table->string('home_logo')->nullable();
            $table->string('away_logo')->nullable();
            $table->dateTime('match_date')->nullable();
            $table->string('match_time')->nullable();
            $table->string('competition')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedInteger('season')->nullable();
            $table->string('stadium')->nullable();
            $table->string('status')->default('SCHEDULED');
            $table->unsignedInteger('home_score')->default(0);
            $table->unsignedInteger('away_score')->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['status', 'match_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixtures');
        Schema::dropIfExists('league_standings');
        Schema::dropIfExists('clubs');
        Schema::dropIfExists('competitions');
        Schema::dropIfExists('seasons');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('sponsors');
        Schema::dropIfExists('players');
        Schema::dropIfExists('teams');
    }
};
