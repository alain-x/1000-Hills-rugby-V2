<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Competition;
use App\Models\Gender;
use App\Models\Season;
use App\Models\Standing;
use App\Support\Activity;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StandingController extends Controller
{
    public function index(Request $request)
    {
        $competitions = Competition::orderBy('name')->get();
        $seasons = Season::orderByDesc('year')->get();
        $genders = Gender::orderBy('name')->get();

        $query = Standing::with(['club', 'competition', 'season', 'gender']);

        if ($request->filled('competition')) {
            $query->where('competition_id', $request->get('competition'));
        }
        if ($request->filled('season')) {
            $query->where('season_id', $request->get('season'));
        }
        if ($request->filled('gender')) {
            $query->where('gender_id', $request->get('gender'));
        }

        $standings = $query->orderByDesc('league_points')->orderByDesc('points_difference')->paginate(25)->withQueryString();

        return view('admin.standings.index', compact('standings', 'competitions', 'seasons', 'genders'));
    }

    public function create()
    {
        $standing = new Standing();
        $clubs = Club::orderBy('name')->get();
        $competitions = Competition::orderBy('name')->get();
        $seasons = Season::orderByDesc('year')->get();
        $genders = Gender::orderBy('name')->get();

        return view('admin.standings.create', compact('standing', 'clubs', 'competitions', 'seasons', 'genders'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['points_difference'] = (int) $data['points_for'] - (int) $data['points_against'];

        $standing = Standing::create($data);
        Activity::log('created', $standing, 'Added league standing');

        return redirect()->route('admin.standings.index')->with('success', 'Standing added.');
    }

    public function edit(Standing $standing)
    {
        $clubs = Club::orderBy('name')->get();
        $competitions = Competition::orderBy('name')->get();
        $seasons = Season::orderByDesc('year')->get();
        $genders = Gender::orderBy('name')->get();

        return view('admin.standings.edit', compact('standing', 'clubs', 'competitions', 'seasons', 'genders'));
    }

    public function update(Request $request, Standing $standing)
    {
        $data = $this->validated($request, $standing->id);
        $data['points_difference'] = (int) $data['points_for'] - (int) $data['points_against'];

        $standing->update($data);
        Activity::log('updated', $standing, 'Updated league standing');

        return redirect()->route('admin.standings.index')->with('success', 'Standing updated.');
    }

    public function destroy(Standing $standing)
    {
        $standing->delete();
        Activity::log('deleted', null, 'Removed league standing');

        return back()->with('success', 'Standing removed.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'club_id' => ['required', 'exists:clubs,id'],
            'competition_id' => ['required', 'exists:competitions,id'],
            'season_id' => ['required', 'exists:seasons,id'],
            'gender_id' => ['required', 'exists:genders,id'],
            'matches_played' => ['nullable', 'integer', 'min:0'],
            'matches_won' => ['nullable', 'integer', 'min:0'],
            'matches_drawn' => ['nullable', 'integer', 'min:0'],
            'matches_lost' => ['nullable', 'integer', 'min:0'],
            'tries_for' => ['nullable', 'integer', 'min:0'],
            'tries_against' => ['nullable', 'integer', 'min:0'],
            'points_for' => ['nullable', 'integer', 'min:0'],
            'points_against' => ['nullable', 'integer', 'min:0'],
            'league_points' => ['nullable', 'integer', 'min:0'],
            'form_score' => ['nullable', 'numeric', 'min:0', 'max:9.99'],
        ]);

        foreach (['matches_played', 'matches_won', 'matches_drawn', 'matches_lost', 'tries_for', 'tries_against', 'points_for', 'points_against', 'league_points'] as $field) {
            $data[$field] = (int) ($data[$field] ?? 0);
        }

        $data['form_score'] = (float) ($data['form_score'] ?? 0);

        $exists = Standing::query()
            ->where('club_id', $data['club_id'])
            ->where('competition_id', $data['competition_id'])
            ->where('season_id', $data['season_id'])
            ->where('gender_id', $data['gender_id'])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'club_id' => 'A standing row already exists for this club, competition, season and gender.',
            ]);
        }

        return $data;
    }
}
