<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerReport;
use App\Support\Activity;
use App\Support\SquadAccess;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlayerReportController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $teams = SquadAccess::teamsFor($user);
        $team = $request->filled('team') || $user->isCoach()
            ? SquadAccess::team($user, $request->get('team'))
            : null;

        $reports = PlayerReport::query()
            ->with(['player', 'team', 'coach'])
            ->when($user->isCoach(), fn ($query) => $query->where('team_id', $user->team_id))
            ->when($team && ! $user->isCoach(), fn ($query) => $query->where('team_id', $team->id))
            ->when($request->filled('player'), fn ($query) => $query->where('player_id', $request->integer('player')))
            ->latest('report_date')
            ->paginate(15)
            ->withQueryString();

        $players = SquadAccess::players($team ?? ($user->isCoach() ? $teams->first() : null));

        return view('admin.reports.index', compact('reports', 'teams', 'team', 'players'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $teams = SquadAccess::teamsFor($user);
        $team = SquadAccess::team($user, $request->get('team'));
        $players = SquadAccess::players($team);
        $report = new PlayerReport([
            'team_id' => $team?->id,
            'report_date' => now()->toDateString(),
            'effort' => 3,
            'skill' => 3,
            'discipline' => 3,
            'teamwork' => 3,
            'fitness' => 3,
        ]);

        return view('admin.reports.create', compact('report', 'teams', 'team', 'players'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['coach_id'] = $request->user()->id;
        $data['rating'] = PlayerReport::ratingFrom($data);

        $report = PlayerReport::create($data);
        Activity::log('created', $report, 'Rated '.$report->player->name.' ('.$report->rating.'/5)');

        return redirect()->route('admin.reports.show', $report)->with('success', 'Player report saved.');
    }

    public function show(PlayerReport $report)
    {
        $this->visibleToCurrentUser($report);
        $report->load(['player', 'team', 'coach']);

        return view('admin.reports.show', compact('report'));
    }

    public function edit(Request $request, PlayerReport $report)
    {
        $this->ownedBy($request, $report);
        $user = $request->user();
        $teams = SquadAccess::teamsFor($user);
        $team = $report->team;
        $players = SquadAccess::players($team);

        return view('admin.reports.edit', compact('report', 'teams', 'team', 'players'));
    }

    public function update(Request $request, PlayerReport $report)
    {
        $this->ownedBy($request, $report);
        $data = $this->validated($request);
        $data['rating'] = PlayerReport::ratingFrom($data);
        $report->update($data);
        Activity::log('updated', $report, 'Updated report for '.$report->player->name);

        return redirect()->route('admin.reports.show', $report)->with('success', 'Player report updated.');
    }

    public function destroy(Request $request, PlayerReport $report)
    {
        $this->ownedBy($request, $report);
        $name = $report->player->name;
        $report->delete();
        Activity::log('deleted', null, 'Deleted performance report for '.$name);

        return redirect()->route('admin.reports.index')->with('success', 'Report deleted.');
    }

    private function validated(Request $request): array
    {
        $user = $request->user();
        $team = SquadAccess::team($user, $request->input('team_id'));
        abort_unless($team, 422, 'Choose a squad first.');

        $playerIds = SquadAccess::players($team)->pluck('id')->all();
        $scores = [];
        foreach (array_keys(PlayerReport::SCORES) as $score) {
            $scores[$score] = ['required', 'integer', 'between:1,5'];
        }

        $data = $request->validate([
            'player_id' => ['required', 'integer', Rule::in($playerIds)],
            'report_date' => ['required', 'date'],
            'report' => ['required', 'string', 'min:20', 'max:5000'],
            ...$scores,
        ]);

        $data['team_id'] = $team->id;

        return $data;
    }

    private function visibleToCurrentUser(PlayerReport $report): void
    {
        $user = auth()->user();
        abort_unless($user && (! $user->isCoach() || (int) $report->team_id === (int) $user->team_id), 403);
    }

    private function ownedBy(Request $request, PlayerReport $report): void
    {
        abort_unless((int) $report->coach_id === (int) $request->user()->id, 403, 'You can only change reports you wrote.');
    }
}
