@extends('admin.layouts.app')

@section('page_title', 'Edit schedule entry')
@section('page_subtitle', $schedule->day.' · '.$schedule->activity)

@section('content')
<div class="page-head">
    <div><h1>Edit schedule entry</h1><div class="sub">{{ $schedule->day }} · {{ $schedule->time_range }}</div></div>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')
<form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="form-admin">
    @csrf @method('PUT')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card-panel">
                <div class="card-panel-header"><h5 class="mb-0">Schedule details</h5></div>
                <div class="card-panel-body">
                    <div class="mb-3">
                        <label class="form-label" for="day">Day <span class="text-danger">*</span></label>
                        <select id="day" name="day" class="form-select" required>
                            @foreach(\App\Models\WeeklySchedule::DAYS as $day)<option value="{{ $day }}" @selected(old('day', $schedule->day) === $day)>{{ $day }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="time_range">Time <span class="text-danger">*</span></label>
                        <input type="text" id="time_range" name="time_range" value="{{ old('time_range', $schedule->time_range) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="activity">Activity <span class="text-danger">*</span></label>
                        <input type="text" id="activity" name="activity" value="{{ old('activity', $schedule->activity) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="location">Location <span class="text-danger">*</span></label>
                        <input type="text" id="location" name="location" value="{{ old('location', $schedule->location) }}" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" for="sort_order">Sort order</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $schedule->sort_order) }}" min="0" class="form-control">
                        </div>
                        <div class="col-6 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $schedule->is_active))>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>Save changes</button>
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-admin-outline">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
