@extends('admin.layouts.app')

@section('page_title', 'Players')
@section('page_subtitle', 'Squad profiles, positions and statistics')

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
        <h1>Players</h1>
        <div class="sub">{{ $players->total() }} player profile{{ $players->total() === 1 ? '' : 's' }}</div>
    </div>
    <a href="{{ route('admin.players.create') }}" class="btn btn-admin-forest"><i class="bi bi-person-plus me-1"></i>Add player</a>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.players.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Name or position">
            </div>
            <div class="col-md-3">
                <label class="form-label">Squad</label>
                <select name="team" class="form-select">
                    <option value="">All squads</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->category }}" @selected(request('team') === $team->category)>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.players.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Squad</th>
                    <th>Position</th>
                    <th>Role</th>
                    <th>Apps</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($players as $player)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ media_url($player->image, 'images/placeholder.svg') }}" alt="" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;">
                                <div>
                                    <div class="fw-semibold">{{ $player->name }}</div>
                                    <div class="text-muted small">{{ $player->nationality ?: 'Nationality not set' }}@if($player->age) · {{ $player->age }} yrs @endif</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted small">{{ $categoryLabels[$player->team] ?? ucfirst(str_replace('_', ' ', $player->team)) }}</td>
                        <td><span class="badge-soft">{{ $player->position_category ?: 'Squad' }}</span>@if($player->role)<div class="text-muted small mt-1">{{ $player->role }}</div>@endif</td>
                        <td>{!! $player->special_role ? '<span class="badge-soft badge-warn">'.$player->special_role.'</span>' : '<span class="text-muted">—</span>' !!}</td>
                        <td class="text-muted">{{ $player->games }}</td>
                        <td>{!! $player->is_published ? '<span class="badge-soft">Published</span>' : '<span class="badge-muted">Draft</span>' !!}</td>
                        <td class="text-end text-nowrap">
                            @if($player->is_published)
                                <a href="{{ route('players.show', $player) }}" target="_blank" rel="noopener" class="btn btn-admin-outline btn-sm" title="View"><i class="bi bi-eye"></i></a>
                            @endif
                            <a href="{{ route('admin.players.edit', $player) }}" class="btn btn-admin-outline btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.players.destroy', $player) }}" method="POST" class="d-inline" data-confirm="Remove this player profile?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">No players found. <a href="{{ route('admin.players.create') }}">Add the first player</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $players->links() }}</div>
@endsection
