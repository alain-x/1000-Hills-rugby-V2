<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerAttendance;
use App\Models\SquadSession;
use App\Support\Activity;
use App\Support\SquadAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.sessions.index');
    }

    public function store(Request $request, SquadSession $squadSession)
    {
        $user = $request->user();
        abort_unless($user->isCoach() && (int) $user->team_id === (int) $squadSession->team_id, 403);
        abort_if($squadSession->status === 'cancelled', 422, 'This session was cancelled.');

        $playerIds = SquadAccess::players($squadSession->team)->pluck('id')->all();

        $data = $request->validate([
            'status' => ['required', 'array'],
            'status.*' => ['required', Rule::in(array_keys(PlayerAttendance::STATUSES))],
            'minutes' => ['nullable', 'array'],
            'minutes.*' => ['nullable', 'integer', 'min:0', 'max:240'],
            'rpe' => ['nullable', 'array'],
            'rpe.*' => ['nullable', 'integer', 'min:1', 'max:10'],
            'note' => ['nullable', 'array'],
            'note.*' => ['nullable', 'string', 'max:200'],
        ]);

        DB::transaction(function () use ($data, $squadSession, $user, $playerIds) {
            foreach ($data['status'] as $playerId => $status) {
                if (! in_array((int) $playerId, $playerIds, true)) {
                    continue;
                }

                $attended = in_array($status, PlayerAttendance::ATTENDED, true);

                PlayerAttendance::query()->updateOrCreate(
                    [
                        'session_id' => $squadSession->id,
                        'player_id' => $playerId,
                    ],
                    [
                        'team_id' => $squadSession->team_id,
                        'coach_id' => $user->id,
                        'session_date' => $squadSession->starts_at->toDateString(),
                        'session_type' => $squadSession->session_type,
                        'status' => $status,
                        'minutes' => $attended ? ($data['minutes'][$playerId] ?? $squadSession->duration_minutes) : null,
                        'rpe' => $attended ? ($data['rpe'][$playerId] ?? null) : null,
                        'note' => $data['note'][$playerId] ?? null,
                    ]
                );
            }

            if ($squadSession->status === 'scheduled' && $squadSession->starts_at->lte(now()->endOfDay())) {
                $squadSession->update(['status' => 'completed']);
            }
        });

        Activity::log('updated', $squadSession, 'Recorded attendance for '.$squadSession->title);

        return redirect()->route('admin.sessions.show', $squadSession)->with('success', 'Register saved.');
    }
}
