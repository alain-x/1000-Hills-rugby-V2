<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Support\Activity;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::withCount('standings')->orderBy('name')->get();

        return view('admin.competitions.index', compact('competitions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:competitions,name'],
            'description' => ['nullable', 'string'],
        ]);

        $competition = Competition::create($data + ['is_active' => $request->boolean('is_active', true)]);
        Activity::log('created', $competition, 'Created competition: '.$competition->name);

        return back()->with('success', 'Competition added.');
    }

    public function update(Request $request, Competition $competition)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:competitions,name,'.$competition->id],
            'description' => ['nullable', 'string'],
        ]);

        $competition->update($data + ['is_active' => $request->boolean('is_active')]);
        Activity::log('updated', $competition, 'Updated competition: '.$competition->name);

        return back()->with('success', 'Competition updated.');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();
        Activity::log('deleted', null, 'Deleted competition');

        return back()->with('success', 'Competition deleted.');
    }
}
