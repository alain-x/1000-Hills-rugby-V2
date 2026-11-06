<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Support\Activity;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::orderBy('sort_order')->paginate(20);

        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        $sponsor = new Sponsor(['is_active' => true]);

        return view('admin.sponsors.create', compact('sponsor'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['logo_path'] = upload_media($request->file('logo'), 'sponsors');

        $sponsor = Sponsor::create($data);
        Activity::log('created', $sponsor, 'Added sponsor');

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor added.');
    }

    public function show(Sponsor $sponsor)
    {
        return redirect()->route('admin.sponsors.edit', $sponsor);
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $data = $this->validated($request);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = upload_media($request->file('logo'), 'sponsors', $sponsor->logo_path);
        } else {
            unset($data['logo_path']);
        }

        if ($request->boolean('remove_logo')) {
            delete_media($sponsor->logo_path);
            $data['logo_path'] = null;
        }

        $sponsor->update($data);
        Activity::log('updated', $sponsor, 'Updated sponsor');

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated.');
    }

    public function destroy(Sponsor $sponsor)
    {
        delete_media($sponsor->logo_path);
        $sponsor->delete();
        Activity::log('deleted', null, 'Removed sponsor');

        return back()->with('success', 'Sponsor removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'tier' => ['nullable', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:4096'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
