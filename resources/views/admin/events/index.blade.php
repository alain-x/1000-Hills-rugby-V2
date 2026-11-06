@extends('admin.layouts.app')

@section('page_title', 'Events')
@section('page_subtitle', 'Manage tournaments, community days and fixtures')

@section('content')
<div class="page-head">
    <div>
        <h1>Events</h1>
        <div class="sub">{{ $events->total() }} event{{ $events->total() === 1 ? '' : 's' }}</div>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>New event</a>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.events.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Title or location">
            </div>
            <div class="col-md-4">
                <label class="form-label">When</label>
                <select name="when" class="form-select">
                    <option value="">All events</option>
                    <option value="upcoming" @selected(request('when') === 'upcoming')>Upcoming</option>
                    <option value="past" @selected(request('when') === 'past')>Past</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Frequency</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ media_url($event->image, 'images/placeholder.svg') }}" alt="" class="rounded" style="width:64px;height:48px;object-fit:cover;">
                                <div>
                                    <div class="fw-semibold">{{ $event->title }}</div>
                                    @if($event->event_time)<div class="text-muted small">{{ $event->event_time }}</div>@endif
                                </div>
                            </div>
                        </td>
                        <td class="text-nowrap">{{ $event->event_date->format('d M Y') }}</td>
                        <td class="text-muted">{{ $event->location ?: '—' }}</td>
                        <td><span class="badge-soft">{{ $event->frequency }}</span></td>
                        <td>{!! $event->is_published ? '<span class="badge-soft">Published</span>' : '<span class="badge-muted">Draft</span>' !!}</td>
                        <td class="text-end text-nowrap">
                            @if($event->is_published)<a href="{{ route('events.show', $event) }}" target="_blank" rel="noopener" class="btn btn-admin-outline btn-sm"><i class="bi bi-eye"></i></a>@endif
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" data-confirm="Delete this event?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No events found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $events->links() }}</div>
@endsection
