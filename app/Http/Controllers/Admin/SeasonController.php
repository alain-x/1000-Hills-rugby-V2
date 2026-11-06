<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Support\Activity;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index()
    {
        $seasons = Season::withCount('standings')->orderByDesc('year')->get();

        return view('admin.seasons.index', compact('seasons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'min:1990', 'max:2100', 'unique:seasons,year'],
        ]);

        $season = Season::create($data + ['is_active' => $request->boolean('is_active', true)]);
        Activity::log('created', $season, 'Created season '.$season->year);

        return back()->with('success', 'Season added.');
    }

    public function update(Request $request, Season $season)
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'min:1990', 'max:2100', 'unique:seasons,year,'.$season->id],
        ]);

        $season->update($data + ['is_active' => $request->boolean('is_active')]);
        Activity::log('updated', $season, 'Updated season '.$season->year);

        return back()->with('success', 'Season updated.');
    }

    public function destroy(Season $season)
    {
        $season->delete();
        Activity::log('deleted', null, 'Deleted season');

        return back()->with('success', 'Season deleted.');
    }
}
