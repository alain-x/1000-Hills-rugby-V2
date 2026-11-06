<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::active()->withCount(['players' => fn ($q) => $q->where('is_published', true)])->get();

        return view('public.teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        abort_unless($team->is_active, 404);

        $filter = request('filter', 'all');
        $search = trim((string) request('q'));

        $players = Player::published()
            ->where('team', $team->category)
            ->when($filter === 'Forwards' || $filter === 'Backs', fn ($q) => $q->where('position_category', $filter))
            ->when(in_array($filter, ['Captain', 'Vice-Captain'], true), fn ($q) => $q->where('special_role', $filter))
            ->when($search !== '', fn ($q) => $q->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")->orWhere('role', 'like', "%{$search}%");
            }))
            ->orderByRaw("CASE WHEN special_role = 'Captain' THEN 0 WHEN special_role = 'Vice-Captain' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->get();

        $squadTeams = Team::active()->get();

        return view('public.teams.show', compact('team', 'players', 'filter', 'search', 'squadTeams'));
    }
}
