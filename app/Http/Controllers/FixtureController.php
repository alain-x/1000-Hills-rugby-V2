<?php

namespace App\Http\Controllers;

use App\Models\Fixture;

class FixtureController extends Controller
{
    public function index()
    {
        $seasons = Fixture::published()->whereNotNull('season')->distinct()->orderByDesc('season')->pluck('season');
        $competitions = Fixture::published()->whereNotNull('competition')->distinct()->orderBy('competition')->pluck('competition');

        $season = (int) (request('season') ?: ($seasons->first() ?? now()->year));
        $competition = (string) request('competition', '');
        $gender = strtoupper((string) request('gender', ''));

        $query = Fixture::published()
            ->when($season, fn ($q) => $q->where('season', $season))
            ->when($competition !== '', fn ($q) => $q->where('competition', $competition))
            ->when(in_array($gender, ['MEN', 'WOMEN'], true), fn ($q) => $q->where('gender', $gender));

        $upcoming = (clone $query)->upcoming()->get();
        $results = (clone $query)->completed()->take(40)->get();

        return view('public.fixtures.index', compact(
            'seasons', 'competitions', 'upcoming', 'results', 'season', 'competition', 'gender'
        ));
    }
}
