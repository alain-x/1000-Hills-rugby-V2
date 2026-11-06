<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;
use App\Support\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::orderBy('sort_order')->get();
        $query = Player::query()->with('teamRelation');

        if ($request->filled('team')) {
            $query->where('team', $request->get('team'));
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->get('status') === 'published');
        }

        if ($search = trim((string) $request->get('q'))) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('role', 'like', "%{$search}%"));
        }

        $players = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.players.index', compact('players', 'teams'));
    }

    public function create()
    {
        $player = new Player(['is_published' => true, 'team' => 'men']);
        $teams = Team::orderBy('sort_order')->get();

        return view('admin.players.create', compact('player', 'teams'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['name'], Player::class);
        $data['image'] = upload_media($request->file('image'), 'players');
        $data = $this->normalise($data);

        $player = Player::create($data);
        Activity::log('created', $player, 'Added player: '.$player->name);

        return redirect()->route('admin.players.index')->with('success', 'Player added successfully.');
    }

    public function show(Player $player)
    {
        return redirect()->route('admin.players.edit', $player);
    }

    public function edit(Player $player)
    {
        $teams = Team::orderBy('sort_order')->get();

        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, Player $player)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['name'], Player::class, $player->id);

        if ($request->hasFile('image')) {
            $data['image'] = upload_media($request->file('image'), 'players', $player->image);
        } else {
            unset($data['image']);
        }

        if ($request->boolean('remove_image')) {
            delete_media($player->image);
            $data['image'] = null;
        }

        $player->update($this->normalise($data));
        Activity::log('updated', $player, 'Updated player: '.$player->name);

        return redirect()->route('admin.players.index')->with('success', 'Player updated successfully.');
    }

    public function destroy(Player $player)
    {
        delete_media($player->image);
        $name = $player->name;
        $player->delete();
        Activity::log('deleted', null, 'Removed player: '.$name);

        return back()->with('success', 'Player removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'team_id' => ['nullable', 'exists:teams,id'],
            'team' => ['required', 'string', 'max:40'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'age' => ['nullable', 'integer', 'min:10', 'max:80'],
            'role' => ['nullable', 'string', 'max:80'],
            'position_category' => ['nullable', 'string', 'max:40'],
            'special_role' => ['nullable', 'string', 'max:40'],
            'weight' => ['nullable', 'string', 'max:20'],
            'height' => ['nullable', 'string', 'max:20'],
            'games' => ['nullable', 'integer', 'min:0'],
            'points' => ['nullable', 'integer', 'min:0'],
            'tries' => ['nullable', 'integer', 'min:0'],
            'place_of_birth' => ['nullable', 'string', 'max:120'],
            'nationality' => ['nullable', 'string', 'max:80'],
            'honours' => ['nullable', 'string'],
            'joined' => ['nullable', 'string', 'max:20'],
            'previous_clubs' => ['nullable', 'string'],
            'sponsor' => ['nullable', 'string', 'max:120'],
            'sponsor_desc' => ['nullable', 'string'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function normalise(array $data): array
    {
        foreach (['games', 'points', 'tries'] as $field) {
            $data[$field] = (int) ($data[$field] ?? 0);
        }

        if (! empty($data['date_of_birth'])) {
            $data['age'] = Carbon::parse($data['date_of_birth'])->age;
        }

        if (! empty($data['team_id'])) {
            $team = Team::find($data['team_id']);
            if ($team) {
                $data['team'] = $team->category;
            }
        }

        return $data;
    }
}
