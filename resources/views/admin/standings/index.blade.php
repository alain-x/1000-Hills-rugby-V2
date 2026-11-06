@extends('admin.layouts.app')

@section('page_title', 'League standings')
@section('page_subtitle', 'Tables for every competition, season and gender')

@section('content')
<div class="page-head">
    <div>
        <h1>League standings</h1>
        <div class="sub">{{ $standings->total() }} table row{{ $standings->total() === 1 ? '' : 's' }}</div>
    </div>
    <a href="{{ route('admin.standings.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>Add standing</a>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.standings.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Competition</label>
                <select name="competition" class="form-select">
                    <option value="">All competitions</option>
                    @foreach($competitions as $competition)
                        <option value="{{ $competition->id }}" @selected((string) request('competition') === (string) $competition->id)>{{ $competition->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Season</label>
                <select name="season" class="form-select">
                    <option value="">All seasons</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season->id }}" @selected((string) request('season') === (string) $season->id)>{{ $season->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">All genders</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}" @selected((string) request('gender') === (string) $gender->id)>{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.standings.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Club</th>
                    <th>Competition</th>
                    <th>Season</th>
                    <th>Gender</th>
                    <th class="text-center">P</th>
                    <th class="text-center">W</th>
                    <th class="text-center">D</th>
                    <th class="text-center">L</th>
                    <th class="text-center">PF</th>
                    <th class="text-center">PA</th>
                    <th class="text-center">PD</th>
                    <th class="text-center">Pts</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($standings as $standing)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ media_url($standing->club?->logo, 'images/placeholder.svg') }}" alt="" class="rounded" style="width:28px;height:28px;object-fit:contain;">
                                <span class="fw-semibold">{{ $standing->club?->name ?: 'Unknown club' }}</span>
                            </div>
                        </td>
                        <td class="small">{{ $standing->competition?->name ?: '—' }}</td>
                        <td class="text-muted">{{ $standing->season?->year ?: '—' }}</td>
                        <td><span class="badge-soft">{{ $standing->gender?->name ?: '—' }}</span></td>
                        <td class="text-center">{{ $standing->matches_played }}</td>
                        <td class="text-center">{{ $standing->matches_won }}</td>
                        <td class="text-center">{{ $standing->matches_drawn }}</td>
                        <td class="text-center">{{ $standing->matches_lost }}</td>
                        <td class="text-center">{{ $standing->points_for }}</td>
                        <td class="text-center">{{ $standing->points_against }}</td>
                        <td class="text-center">{{ $standing->points_difference }}</td>
                        <td class="text-center fw-bold">{{ $standing->league_points }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.standings.edit', $standing) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.standings.destroy', $standing) }}" method="POST" class="d-inline" data-confirm="Remove this standing row?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="13" class="text-center text-muted py-5">No standings found. <a href="{{ route('admin.standings.create') }}">Add the first row</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $standings->links() }}</div>
@endsection
