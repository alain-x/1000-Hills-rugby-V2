<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerAttendance;
use App\Models\SquadSession;
use App\Support\Activity;
use App\Support\SquadAccess;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SquadSessionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $teams = SquadAccess::teamsFor($user);
        $team = $request->filled('team') || $user->isCoach()
            ? SquadAccess::team($user, $request->get('team'))
            : null;

        $sessions = SquadSession::query()
            ->with('team')
            ->withCount([
                'attendances as attended_count' => fn ($query) => $query->whereIn('status', PlayerAttendance::ATTENDED),
                'attendances',
            ])
            ->when($user->isCoach(), fn ($query) => $query->where('team_id', $user->team_id))
            ->when($team && ! $user->isCoach(), fn ($query) => $query->where('team_id', $team->id))
            ->orderByDesc('starts_at')
            ->paginate(12)
            ->withQueryString();

        $summaryTeam = $team ?? ($user->isCoach() ? $teams->first() : null);
        $rates = $this->attendanceRates($summaryTeam);

        return view('admin.sessions.index', compact('teams', 'team', 'sessions', 'rates', 'summaryTeam'));
    }

    public function create(Request $request)
    {
        $teams = SquadAccess::teamsFor($request->user());
        $session = new SquadSession([
            'starts_at' => now()->addDay()->setTime(16, 0),
            'duration_minutes' => 90,
            'session_type' => 'training',
            'intensity' => 'medium',
            'focus' => 'general',
            'status' => 'scheduled',
            'team_id' => $request->integer('team') ?: $teams->first()?->id,
        ]);

        return view('admin.sessions.create', compact('teams', 'session'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->id;
        $session = SquadSession::create($data);

        Activity::log('created', $session, 'Scheduled '.$session->title);

        return redirect()->route('admin.sessions.show', $session)->with('success', 'Session scheduled. The squad coach can now take the register.');
    }

    public function show(Request $request, SquadSession $squadSession)
    {
        $this->guard($request, $squadSession);

        $players = SquadAccess::players($squadSession->team);
        $marks = $squadSession->attendances()->get()->keyBy('player_id');
        $counts = $marks->countBy('status');
        $attended = $marks->whereIn('status', PlayerAttendance::ATTENDED)->count();
        $squadSize = $players->count();
        $rate = $squadSize > 0 && $marks->isNotEmpty() ? (int) round(($attended / $squadSize) * 100) : null;
        $load = $marks->sum(fn (PlayerAttendance $mark) => $mark->loadScore() ?? 0);

        return view('admin.sessions.show', compact('squadSession', 'players', 'marks', 'counts', 'attended', 'rate', 'load'));
    }

    public function edit(Request $request, SquadSession $squadSession)
    {
        $teams = SquadAccess::teamsFor($request->user());
        $session = $squadSession;

        return view('admin.sessions.edit', compact('teams', 'session'));
    }

    public function update(Request $request, SquadSession $squadSession)
    {
        $squadSession->update($this->validated($request));
        Activity::log('updated', $squadSession, 'Updated '.$squadSession->title);

        return redirect()->route('admin.sessions.show', $squadSession)->with('success', 'Session updated.');
    }

    public function destroy(SquadSession $squadSession)
    {
        $title = $squadSession->title;
        Activity::log('deleted', $squadSession, 'Removed '.$title);
        $squadSession->delete();

        return redirect()->route('admin.sessions.index')->with('success', $title.' was removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'team_id' => ['required', Rule::exists('teams', 'id')],
            'title' => ['required', 'string', 'max:160'],
            'session_type' => ['required', Rule::in(array_keys(SquadSession::TYPES))],
            'focus' => ['nullable', Rule::in(array_keys(SquadSession::FOCUSES))],
            'starts_at' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'location' => ['nullable', 'string', 'max:160'],
            'intensity' => ['required', Rule::in(array_keys(SquadSession::INTENSITIES))],
            'opponent' => ['nullable', 'string', 'max:160'],
            'status' => ['required', Rule::in(array_keys(SquadSession::STATUSES))],
            'plan' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($data['session_type'] !== 'match') {
            $data['opponent'] = $data['opponent'] ?: null;
        }

        return $data;
    }

    private function guard(Request $request, SquadSession $session): void
    {
        $user = $request->user();
        abort_if($user->isCoach() && (int) $user->team_id !== (int) $session->team_id, 403);
    }

    private function attendanceRates($team)
    {
        if (! $team) {
            return collect();
        }

        $sessionIds = SquadSession::query()
            ->where('team_id', $team->id)
            ->where('status', '!=', 'cancelled')
            ->where('starts_at', '<=', now()->endOfDay())
            ->latest('starts_at')
            ->limit(8)
            ->pluck('id');

        if ($sessionIds->isEmpty()) {
            return collect();
        }

        $marks = PlayerAttendance::query()
            ->with('player')
            ->whereIn('session_id', $sessionIds)
            ->get()
            ->groupBy('player_id');

        return $marks->map(function ($rows) {
            $attended = $rows->whereIn('status', PlayerAttendance::ATTENDED)->count();
            $latest = $rows->sortByDesc('session_date')->first();

            return [
                'player' => $latest->player,
                'rate' => (int) round(($attended / $rows->count()) * 100),
                'sessions' => $rows->count(),
                'load' => $rows->sum(fn (PlayerAttendance $mark) => $mark->loadScore() ?? 0),
                'latest' => $latest->status,
            ];
        })->sortBy('player.name')->values();
    }
}
