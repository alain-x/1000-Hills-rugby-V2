@extends('admin.layouts.app')

@section('page_title', $squadSession->title)
@section('page_subtitle', 'Squad register')

@section('content')
@php
    $coach = auth()->user()->isCoach();
    $canRecord = $coach && $squadSession->status !== 'cancelled';
@endphp

<div class="page-head">
    <div>
        <h1>{{ $squadSession->title }}</h1>
        <div class="sub">
            {{ $squadSession->team->name }}
            · {{ $squadSession->starts_at->format('D d M Y, H:i') }}
            · {{ $squadSession->duration_minutes }} min
            · {{ \App\Models\SquadSession::TYPES[$squadSession->session_type] ?? $squadSession->session_type }}
            @if($squadSession->focus) · {{ \App\Models\SquadSession::FOCUSES[$squadSession->focus] }} @endif
            · {{ \App\Models\SquadSession::INTENSITIES[$squadSession->intensity] ?? $squadSession->intensity }} intensity
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.sessions.index', ['team' => $squadSession->team_id]) }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Sessions</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.sessions.edit', $squadSession) }}" class="btn btn-admin-outline">Edit</a>
        @endif
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card-panel p-3"><div class="text-muted small">Attendance</div><div class="h4 mb-0">{{ $rate === null ? '—' : $rate.'%' }}</div></div></div>
    <div class="col-6 col-md-3"><div class="card-panel p-3"><div class="text-muted small">Attended</div><div class="h4 mb-0">{{ $attended }}</div></div></div>
    <div class="col-6 col-md-3"><div class="card-panel p-3"><div class="text-muted small">Injured or sick</div><div class="h4 mb-0">{{ ($counts['injured'] ?? 0) + ($counts['sick'] ?? 0) }}</div></div></div>
    <div class="col-6 col-md-3"><div class="card-panel p-3"><div class="text-muted small">Squad load</div><div class="h4 mb-0">{{ $load ?: '—' }}</div></div></div>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <div class="row g-3">
            <div class="col-md-4"><div class="text-muted small">Location</div><div>{{ $squadSession->location ?: 'Not set' }}</div></div>
            <div class="col-md-4"><div class="text-muted small">Opponent</div><div>{{ $squadSession->opponent ?: '—' }}</div></div>
            <div class="col-md-4"><div class="text-muted small">Status</div><div>{{ \App\Models\SquadSession::STATUSES[$squadSession->status] ?? $squadSession->status }}</div></div>
            @if($squadSession->plan)
                <div class="col-12"><div class="text-muted small">Plan</div><div style="white-space:pre-wrap;">{{ $squadSession->plan }}</div></div>
            @endif
        </div>
    </div>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.sessions.attendance', $squadSession) }}" method="POST" id="register-form">
    @csrf
    <div class="card-panel">
        <div class="card-panel-body d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <h2 class="h5 mb-1">Register</h2>
                <p class="text-muted small mb-0">Minutes and RPE (1 easy, 10 maximal) are used for players who are present or late. Load is minutes × RPE.</p>
            </div>
            @if($canRecord)
                <button type="button" class="btn btn-admin-outline btn-sm" id="mark-all-present">Mark all present</button>
            @else
                <span class="text-muted small">Only the squad coach records this register.</span>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table table-admin align-middle mb-0">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Status</th>
                        <th>Minutes</th>
                        <th>RPE</th>
                        <th>Load</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($players as $player)
                        @php($mark = $marks->get($player->id))
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $player->name }}</div>
                                <div class="text-muted small">{{ $player->role ?: $player->position_category }}</div>
                            </td>
                            <td style="min-width:140px;">
                                <select name="status[{{ $player->id }}]" class="form-select form-select-sm status-select" @disabled(! $canRecord)>
                                    @foreach(\App\Models\PlayerAttendance::STATUSES as $value => $label)
                                        <option value="{{ $value }}" @selected(old('status.'.$player->id, $mark?->status ?? 'present') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:110px;">
                                <input type="number" name="minutes[{{ $player->id }}]" class="form-control form-control-sm minutes-input" min="0" max="240" value="{{ old('minutes.'.$player->id, $mark?->minutes ?? $squadSession->duration_minutes) }}" @disabled(! $canRecord)>
                            </td>
                            <td style="width:90px;">
                                <input type="number" name="rpe[{{ $player->id }}]" class="form-control form-control-sm" min="1" max="10" value="{{ old('rpe.'.$player->id, $mark?->rpe) }}" @disabled(! $canRecord)>
                            </td>
                            <td>{{ $mark?->loadScore() ?: '—' }}</td>
                            <td>
                                <input type="text" name="note[{{ $player->id }}]" class="form-control form-control-sm" maxlength="200" value="{{ old('note.'.$player->id, $mark?->note) }}" placeholder="Niggle, reason, arrival" @disabled(! $canRecord)>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">This squad has no players yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($canRecord && $players->isNotEmpty())
            <div class="card-panel-body border-top">
                <button class="btn btn-admin-forest" type="submit">Save register</button>
            </div>
        @endif
    </div>
</form>

@if(auth()->user()->isAdmin())
    <form action="{{ route('admin.sessions.destroy', $squadSession) }}" method="POST" class="mt-3" onsubmit="return confirm('Remove this session and its register?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger btn-sm" type="submit">Delete session</button>
    </form>
@endif
@endsection

@push('scripts')
<script>
document.getElementById('mark-all-present')?.addEventListener('click', function () {
    document.querySelectorAll('.status-select').forEach(function (select) {
        select.value = 'present';
    });
    document.querySelectorAll('.minutes-input').forEach(function (input) {
        if (!input.value) input.value = '{{ $squadSession->duration_minutes }}';
    });
});
</script>
@endpush
