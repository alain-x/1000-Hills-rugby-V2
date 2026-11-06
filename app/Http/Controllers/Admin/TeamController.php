<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Support\Activity;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount('players')->orderBy('sort_order')->orderBy('name')->paginate(12);

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $team = new Team(['is_active' => true, 'category' => 'men']);

        return view('admin.teams.create', compact('team'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['name'], Team::class);
        $data['logo'] = upload_media($request->file('logo'), 'teams');
        $data['cover_image'] = upload_media($request->file('cover_image'), 'teams');

        $team = Team::create($data);
        Activity::log('created', $team, 'Created team: '.$team->name);

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    public function show(Team $team)
    {
        return redirect()->route('admin.teams.edit', $team);
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['name'], Team::class, $team->id);

        if ($request->hasFile('logo')) {
            $data['logo'] = upload_media($request->file('logo'), 'teams', $team->logo);
        } else {
            unset($data['logo']);
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = upload_media($request->file('cover_image'), 'teams', $team->cover_image);
        } else {
            unset($data['cover_image']);
        }

        if ($request->boolean('remove_logo')) {
            delete_media($team->logo);
            $data['logo'] = null;
        }

        if ($request->boolean('remove_cover_image')) {
            delete_media($team->cover_image);
            $data['cover_image'] = null;
        }

        $team->update($data);
        Activity::log('updated', $team, 'Updated team: '.$team->name);

        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
        delete_media($team->logo);
        delete_media($team->cover_image);
        $name = $team->name;
        $team->delete();
        Activity::log('deleted', null, 'Deleted team: '.$name);

        return back()->with('success', 'Team deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:60'],
            'gender' => ['nullable', 'string', 'max:30'],
            'age_group' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'coach' => ['nullable', 'string', 'max:120'],
            'home_ground' => ['nullable', 'string', 'max:150'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:4096'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
        ]);

        $data['slug'] = $data['slug'] ?? '';
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
