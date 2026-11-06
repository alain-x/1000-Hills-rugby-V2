<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Gender;
use App\Models\Season;
use App\Models\Standing;

class StandingController extends Controller
{
    public function index()
    {
        $competitions = Competition::where('is_active', true)->orderBy('name')->get();
        $seasons = Season::where('is_active', true)->orderByDesc('year')->get();
        $genders = Gender::where('is_active', true)->orderBy('name')->get();

        $competitionId = (int) (request('competition') ?: $competitions->first()?->id);
        $seasonId = (int) (request('season') ?: $seasons->first()?->id);
        $genderId = (int) (request('gender') ?: $genders->first()?->id);

        $standings = Standing::with('club')
            ->when($competitionId, fn ($q) => $q->where('competition_id', $competitionId))
            ->when($seasonId, fn ($q) => $q->where('season_id', $seasonId))
            ->when($genderId, fn ($q) => $q->where('gender_id', $genderId))
            ->orderByDesc('league_points')
            ->orderByDesc('points_difference')
            ->orderByDesc('points_for')
            ->get();

        $competition = $competitions->firstWhere('id', $competitionId);
        $season = $seasons->firstWhere('id', $seasonId);
        $gender = $genders->firstWhere('id', $genderId);

        return view('public.tables.index', compact(
            'competitions', 'seasons', 'genders', 'standings',
            'competitionId', 'seasonId', 'genderId', 'competition', 'season', 'gender'
        ));
    }
}
