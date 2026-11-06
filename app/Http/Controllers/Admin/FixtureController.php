<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Support\Activity;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index(Request $request)
    {
        $query = Fixture::query();

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('season')) {
            $query->where('season', $request->get('season'));
        }

        if ($search = trim((string) $request->get('q'))) {
            $query->where(fn ($q) => $q->where('home_team', 'like', "%{$search}%")->orWhere('away_team', 'like', "%{$search}%"));
        }

        $fixtures = $query->orderByDesc('match_date')->paginate(15)->withQueryString();
        $seasons = Fixture::whereNotNull('season')->distinct()->orderByDesc('season')->pluck('season');

        return view('admin.fixtures.index', compact('fixtures', 'seasons'));
    }

    public function create()
    {
        $fixture = new Fixture([
            'match_date' => now()->addWeek(),
            'status' => 'SCHEDULED',
            'season' => current_season(),
            'is_published' => true,
        ]);

        return view('admin.fixtures.create', compact('fixture'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['home_logo'] = upload_media($request->file('home_logo'), 'fixtures');
        $data['away_logo'] = upload_media($request->file('away_logo'), 'fixtures');

        $fixture = Fixture::create($data);
        Activity::log('created', $fixture, 'Created fixture: '.$fixture->home_team.' vs '.$fixture->away_team);

        return redirect()->route('admin.fixtures.index')->with('success', 'Fixture created.');
    }

    public function edit(Fixture $fixture)
    {
        return view('admin.fixtures.edit', compact('fixture'));
    }

    public function update(Request $request, Fixture $fixture)
    {
        $data = $this->validated($request);

        if ($request->hasFile('home_logo')) {
            $data['home_logo'] = upload_media($request->file('home_logo'), 'fixtures', $fixture->home_logo);
        } else {
            unset($data['home_logo']);
        }

        if ($request->hasFile('away_logo')) {
            $data['away_logo'] = upload_media($request->file('away_logo'), 'fixtures', $fixture->away_logo);
        } else {
            unset($data['away_logo']);
        }

        $fixture->update($data);
        Activity::log('updated', $fixture, 'Updated fixture: '.$fixture->home_team.' vs '.$fixture->away_team);

        return redirect()->route('admin.fixtures.index')->with('success', 'Fixture updated.');
    }

    public function destroy(Fixture $fixture)
    {
        delete_media($fixture->home_logo);
        delete_media($fixture->away_logo);
        $label = $fixture->home_team.' vs '.$fixture->away_team;
        $fixture->delete();
        Activity::log('deleted', null, 'Deleted fixture: '.$label);

        return back()->with('success', 'Fixture deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'home_team' => ['required', 'string', 'max:120'],
            'away_team' => ['required', 'string', 'max:120'],
            'match_date' => ['nullable', 'date'],
            'match_time' => ['nullable', 'string', 'max:40'],
            'competition' => ['nullable', 'string', 'max:120'],
            'gender' => ['nullable', 'string', 'max:30'],
            'season' => ['nullable', 'integer', 'min:1990', 'max:2100'],
            'stadium' => ['nullable', 'string', 'max:150'],
            'status' => ['required', 'in:SCHEDULED,COMPLETED,CANCELLED,POSTPONED'],
            'home_score' => ['nullable', 'integer', 'min:0', 'max:999'],
            'away_score' => ['nullable', 'integer', 'min:0', 'max:999'],
            'notes' => ['nullable', 'string'],
            'home_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:4096'],
            'away_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:4096'],
        ]);

        $data['home_score'] = (int) ($data['home_score'] ?? 0);
        $data['away_score'] = (int) ($data['away_score'] ?? 0);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
