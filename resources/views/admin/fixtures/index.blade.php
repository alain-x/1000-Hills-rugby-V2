@extends('admin.layouts.app')

@section('page_title', 'Fixtures & results')
@section('page_subtitle', 'Match schedule, scores and competition details')

@section('content')
<div class="page-head">
    <div>
        <h1>Fixtures &amp; results</h1>
        <div class="sub">{{ $fixtures->total() }} match{{ $fixtures->total() === 1 ? '' : 'es' }} recorded</div>
    </div>
    <a href="{{ route('admin.fixtures.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>New fixture</a>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.fixtures.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Team name">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach(['SCHEDULED', 'COMPLETED', 'CANCELLED', 'POSTPONED'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(strtolower($status)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Season</label>
                <select name="season" class="form-select">
                    <option value="">All seasons</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season }}" @selected((string) request('season') === (string) $season)>{{ $season }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.fixtures.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Match</th>
                    <th>Competition</th>
                    <th>Season</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fixtures as $fixture)
                    <tr>
                        <td class="text-nowrap">
                            <div class="fw-semibold">{{ optional($fixture->match_date)->format('d M Y') ?: 'TBC' }}</div>
                            <div class="text-muted small">{{ $fixture->match_time ?: optional($fixture->match_date)->format('H:i') }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $fixture->home_team }} <span class="text-muted fw-normal">v</span> {{ $fixture->away_team }}</div>
                            <div class="text-muted small">{{ $fixture->stadium ?: 'Venue TBC' }}{{ $fixture->gender ? ' · '.ucfirst(strtolower($fixture->gender)) : '' }}</div>
                        </td>
                        <td>{{ $fixture->competition ?: 'Friendly' }}</td>
                        <td class="text-muted">{{ $fixture->season ?: '—' }}</td>
                        <td>
                            @php($statusClass = match($fixture->status) {
                                'COMPLETED' => 'badge-soft',
                                'SCHEDULED' => 'badge-soft',
                                'CANCELLED', 'POSTPONED' => 'badge-muted',
                                default => 'badge-muted',
                            })
                            <span class="{{ $statusClass }}">{{ ucfirst(strtolower($fixture->status)) }}</span>
                            @unless($fixture->is_published)<span class="badge-muted ms-1">Hidden</span>@endunless
                        </td>
                        <td class="fw-semibold text-nowrap">{{ $fixture->status === 'COMPLETED' ? $fixture->home_score.' – '.$fixture->away_score : '—' }}</td>
                        <td class="text-end text-nowrap">
                            @if($fixture->is_published)
                                <a href="{{ route('fixtures.index') }}" target="_blank" rel="noopener" class="btn btn-admin-outline btn-sm" title="Public fixtures"><i class="bi bi-eye"></i></a>
                            @endif
                            <a href="{{ route('admin.fixtures.edit', $fixture) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.fixtures.destroy', $fixture) }}" method="POST" class="d-inline" data-confirm="Delete this fixture?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">No fixtures found. <a href="{{ route('admin.fixtures.create') }}">Add the first fixture</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $fixtures->links() }}</div>
@endsection
