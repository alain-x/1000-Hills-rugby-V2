@extends('admin.layouts.app')

@section('page_title', 'Squad sessions')
@section('page_subtitle', 'Training, matches and other squad events')

@section('content')
<div class="page-head">
    <div>
        <h1>Squad sessions</h1>
        <div class="sub">Schedule a session, then the coach records the register.</div>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.sessions.create', ['team' => $team?->id]) }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>New session</a>
    @endif
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.sessions.index') }}" method="GET" class="row g-2 align-items-end">
            @unless(auth()->user()->isCoach())
                <div class="col-md-4">
                    <label class="form-label">Squad</label>
                    <select name="team" class="form-select">
                        <option value="">All squads</option>
                        @foreach($teams as $item)
                            <option value="{{ $item->id }}" @selected($team?->id === $item->id)>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endunless
            <div class="col-md-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card-panel mb-4">
    <div class="table-responsive">
        <table class="table table-admin align-middle mb-0">
            <thead>
                <tr>
                    <th>When</th>
                    <th>Session</th>
                    <th>Squad</th>
                    <th>Attendance</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $session->starts_at->format('d M Y') }}</div>
                            <div class="text-muted small">{{ $session->starts_at->format('H:i') }} · {{ $session->duration_minutes }} min</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $session->title }}</div>
                            <div class="text-muted small">
                                {{ \App\Models\SquadSession::TYPES[$session->session_type] ?? $session->session_type }}
                                @if($session->focus) · {{ \App\Models\SquadSession::FOCUSES[$session->focus] ?? $session->focus }} @endif
                                @if($session->opponent) · vs {{ $session->opponent }} @endif
                            </div>
                        </td>
                        <td>{{ $session->team->name }}</td>
                        <td>
                            @if($session->status === 'cancelled')
                                <span class="badge-soft">Cancelled</span>
                            @elseif($session->attendances_count)
                                <span class="badge-soft">{{ $session->attended_count }}/{{ $session->attendances_count }} attended</span>
                            @else
                                <span class="text-muted small">Register open</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.sessions.show', $session) }}" class="btn btn-admin-outline btn-sm">Register</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.sessions.edit', $session) }}" class="btn btn-admin-outline btn-sm">Edit</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">No sessions yet. An administrator can schedule training, a match, gym, recovery, or a meeting.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mb-4 d-flex justify-content-center">{{ $sessions->links() }}</div>

@if($summaryTeam)
    <div class="card-panel">
        <div class="card-panel-body pb-0">
            <h2 class="h5 mb-1">{{ $summaryTeam->name }} attendance</h2>
            <p class="text-muted small mb-3">Present and late marks across the last eight sessions that have a saved register.</p>
        </div>
        <div class="table-responsive">
            <table class="table table-admin align-middle mb-0">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Attendance</th>
                        <th>Sessions</th>
                        <th>Training load</th>
                        <th>Latest mark</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rates as $row)
                        <tr>
                            <td class="fw-semibold">{{ $row['player']?->name }}</td>
                            <td>{{ $row['rate'] }}%</td>
                            <td>{{ $row['sessions'] }}</td>
                            <td>{{ $row['load'] ?: '—' }}</td>
                            <td>{{ \App\Models\PlayerAttendance::STATUSES[$row['latest']] ?? $row['latest'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Attendance appears here after the coach saves a register.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
