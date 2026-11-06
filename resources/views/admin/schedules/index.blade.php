@extends('admin.layouts.app')

@section('page_title', 'Weekly schedule')
@section('page_subtitle', 'Training sessions and regular club activities')

@section('content')
<div class="page-head">
    <div><h1>Weekly schedule</h1><div class="sub">This schedule appears on the events page and homepage.</div></div>
</div>

@include('admin.partials.errors')

<div class="row g-4">
    <div class="col-xl-5">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Add a schedule entry</h5></div>
            <div class="card-panel-body">
                <form action="{{ route('admin.schedules.store') }}" method="POST" class="form-admin">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="day">Day <span class="text-danger">*</span></label>
                        <select id="day" name="day" class="form-select" required>
                            @foreach(\App\Models\WeeklySchedule::DAYS as $day)<option value="{{ $day }}" @selected(old('day') === $day)>{{ $day }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="time_range">Time <span class="text-danger">*</span></label>
                        <input type="text" id="time_range" name="time_range" value="{{ old('time_range') }}" class="form-control" placeholder="e.g. 16:00 - 18:00" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="activity">Activity <span class="text-danger">*</span></label>
                        <input type="text" id="activity" name="activity" value="{{ old('activity') }}" class="form-control" placeholder="e.g. Senior men's training" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="location">Location <span class="text-danger">*</span></label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" class="form-control" placeholder="e.g. Don Bosco Gatenga" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label" for="sort_order">Sort order</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="form-control">
                        </div>
                        <div class="col-6 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-admin-forest w-100" type="submit"><i class="bi bi-plus-lg me-1"></i>Add entry</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Current schedule</h5><span class="text-muted small">{{ $schedules->count() }} entries</span></div>
            <div class="table-responsive">
                <table class="table table-admin align-middle">
                    <thead><tr><th>Day</th><th>Activity</th><th>Time</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td><span class="badge-soft">{{ $schedule->day }}</span></td>
                                <td><div class="fw-semibold">{{ $schedule->activity }}</div><div class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $schedule->location }}</div></td>
                                <td class="text-nowrap">{{ $schedule->time_range }}</td>
                                <td>{!! $schedule->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Hidden</span>' !!}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline" data-confirm="Remove this schedule entry?">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">No schedule entries yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
