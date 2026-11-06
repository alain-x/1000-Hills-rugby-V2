@extends('admin.layouts.app')

@section('page_title', 'Performance reports')
@section('page_subtitle', 'Coach ratings by squad')

@section('content')
<div class="page-head">
    <div>
        <h1>Performance reports</h1>
        <div class="sub">{{ $reports->total() }} report{{ $reports->total() === 1 ? '' : 's' }}</div>
    </div>
    @if(auth()->user()->isCoach())
        <a href="{{ route('admin.reports.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>New report</a>
    @endif
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-2 align-items-end">
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
            <div class="col-md-4">
                <label class="form-label">Player</label>
                <select name="player" class="form-select">
                    <option value="">All players</option>
                    @foreach($players as $player)
                        <option value="{{ $player->id }}" @selected(request('player') == $player->id)>{{ $player->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Player</th>
                    <th>Squad</th>
                    <th>Rating</th>
                    <th>Coach</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->report_date->format('d M Y') }}</td>
                        <td class="fw-semibold">{{ $report->player->name }}</td>
                        <td>{{ $report->team->name }}</td>
                        <td><span class="badge-soft">{{ number_format($report->rating, 1) }} / 5</span></td>
                        <td>{{ $report->coach->name }}</td>
                        <td class="text-end"><a href="{{ route('admin.reports.show', $report) }}" class="btn btn-admin-outline btn-sm">Open</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No performance reports yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $reports->links() }}</div>
@endsection
