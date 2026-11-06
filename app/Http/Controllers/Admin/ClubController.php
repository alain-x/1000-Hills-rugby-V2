<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Support\Activity;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::withCount('standings')->orderBy('name')->get();

        return view('admin.clubs.index', compact('clubs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:clubs,name'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:4096'],
        ]);

        $data['slug'] = unique_slug($data['name'], Club::class);
        $data['logo'] = upload_media($request->file('logo'), 'clubs');
        $data['is_active'] = $request->boolean('is_active', true);

        $club = Club::create($data);
        Activity::log('created', $club, 'Created club: '.$club->name);

        return back()->with('success', 'Club added.');
    }

    public function update(Request $request, Club $club)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:clubs,name,'.$club->id],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:4096'],
        ]);

        $data['slug'] = unique_slug($data['name'], Club::class, $club->id);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $data['logo'] = upload_media($request->file('logo'), 'clubs', $club->logo);
        } else {
            unset($data['logo']);
        }

        $club->update($data);
        Activity::log('updated', $club, 'Updated club: '.$club->name);

        return back()->with('success', 'Club updated.');
    }

    public function destroy(Club $club)
    {
        delete_media($club->logo);
        $club->delete();
        Activity::log('deleted', null, 'Deleted club');

        return back()->with('success', 'Club deleted.');
    }
}
