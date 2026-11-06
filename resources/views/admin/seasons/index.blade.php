@extends('admin.layouts.app')

@section('page_title', 'Seasons')
@section('page_subtitle', 'Competition seasons used across fixtures and standings')

@section('content')
<div class="page-head">
    <div><h1>Seasons</h1><div class="sub">{{ $seasons->count() }} season{{ $seasons->count() === 1 ? '' : 's' }}</div></div>
</div>

@include('admin.partials.errors')

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Add season</h5></div>
            <div class="card-panel-body">
                <form action="{{ route('admin.seasons.store') }}" method="POST" class="form-admin">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="year">Year <span class="text-danger">*</span></label>
                        <input type="number" id="year" name="year" value="{{ old('year', now()->year) }}" min="1990" max="2100" class="form-control" required>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active season</label>
                    </div>
                    <button class="btn btn-admin-forest w-100" type="submit"><i class="bi bi-plus-lg me-1"></i>Add season</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">All seasons</h5></div>
            <div class="table-responsive">
                <table class="table table-admin align-middle">
                    <thead><tr><th>Season</th><th>Standings rows</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse($seasons as $season)
                            <tr>
                                <td class="fw-semibold">{{ $season->year }}</td>
                                <td><span class="badge-soft">{{ $season->standings_count }}</span></td>
                                <td>{!! $season->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Inactive</span>' !!}</td>
                                <td class="text-end text-nowrap">
                                    <button class="btn btn-admin-outline btn-sm" data-bs-toggle="modal" data-bs-target="#season{{ $season->id }}"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.seasons.destroy', $season) }}" method="POST" class="d-inline" data-confirm="Delete this season? Linked standings will also be deleted.">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-5">No seasons yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($seasons as $season)
    <div class="modal fade" id="season{{ $season->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.seasons.update', $season) }}" method="POST" class="modal-content form-admin">
                @csrf @method('PUT')
                <div class="modal-header"><h5 class="modal-title">Edit season</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" value="{{ $season->year }}" min="1990" max="2100" class="form-control" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="seasonActive{{ $season->id }}" @checked($season->is_active)>
                        <label class="form-check-label" for="seasonActive{{ $season->id }}">Active season</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-admin-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-admin-forest">Save changes</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
@endsection
