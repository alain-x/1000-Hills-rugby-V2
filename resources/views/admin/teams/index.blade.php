@extends('admin.layouts.app')

@section('page_title', 'Teams')
@section('page_subtitle', 'Senior and academy squads')

@php($categoryLabels = [
    'men' => "Men's senior squad",
    'women' => "Women's senior squad",
    'academy_u18_boys' => 'U18 boys academy',
    'academy_u18_girls' => 'U18 girls academy',
    'academy_u16_boys' => 'U16 boys academy',
    'academy_u16_girls' => 'U16 girls academy',
])

@section('content')
<div class="page-head">
    <div>
        <h1>Teams</h1>
        <div class="sub">{{ $teams->total() }} squad{{ $teams->total() === 1 ? '' : 's' }} registered</div>
    </div>
    <a href="{{ route('admin.teams.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>New team</a>
</div>

<div class="row g-4">
    @forelse($teams as $team)
        <div class="col-md-6 col-xl-4">
            <div class="card-panel h-100">
                <div class="card-panel-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ media_url($team->logo, 'images/1000-hills-logo.png') }}" alt="" class="rounded border bg-white p-1" style="width:56px;height:56px;object-fit:contain;">
                            <div>
                                <div class="fw-semibold">{{ $team->name }}</div>
                                <div class="text-muted small">{{ $categoryLabels[$team->category] ?? ucfirst(str_replace('_', ' ', $team->category)) }}</div>
                            </div>
                        </div>
                        {!! $team->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Hidden</span>' !!}
                    </div>
                    <div class="row g-2 text-center mb-3">
                        <div class="col-4"><div class="fw-bold">{{ $team->players_count }}</div><div class="text-muted small">Players</div></div>
                        <div class="col-4"><div class="fw-bold">{{ $team->age_group ?: 'Senior' }}</div><div class="text-muted small">Group</div></div>
                        <div class="col-4"><div class="fw-bold">{{ $team->sort_order }}</div><div class="text-muted small">Order</div></div>
                    </div>
                    <div class="text-muted small mb-3">
                        <div><i class="bi bi-person-badge me-1"></i>{{ $team->coach ?: 'Coach not set' }}</div>
                        <div><i class="bi bi-geo-alt me-1"></i>{{ $team->home_ground ?: 'Home ground not set' }}</div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.players.index', ['team' => $team->category]) }}" class="btn btn-admin-outline btn-sm flex-grow-1"><i class="bi bi-people me-1"></i>Squad</a>
                        <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" data-confirm="Delete this team? Players will remain but become unlinked.">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="card-panel"><div class="card-panel-body text-center text-muted py-5">No teams yet. <a href="{{ route('admin.teams.create') }}">Create the first team</a>.</div></div></div>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">{{ $teams->links() }}</div>
@endsection
