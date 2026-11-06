@extends('admin.layouts.app')

@section('page_title', 'Competitions')
@section('page_subtitle', 'Leagues, cups and tournaments')

@section('content')
<div class="page-head">
    <div><h1>Competitions</h1><div class="sub">{{ $competitions->count() }} competition{{ $competitions->count() === 1 ? '' : 's' }}</div></div>
</div>

@include('admin.partials.errors')

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Add competition</h5></div>
            <div class="card-panel-body">
                <form action="{{ route('admin.competitions.store') }}" method="POST" class="form-admin">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Competition name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Rwanda Premier League" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                    <button class="btn btn-admin-forest w-100" type="submit"><i class="bi bi-plus-lg me-1"></i>Add competition</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">All competitions</h5></div>
            <div class="table-responsive">
                <table class="table table-admin align-middle">
                    <thead><tr><th>Name</th><th>Description</th><th>Rows</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse($competitions as $competition)
                            <tr>
                                <td class="fw-semibold">{{ $competition->name }}</td>
                                <td class="text-muted small text-truncate" style="max-width:280px;">{{ $competition->description ?: '—' }}</td>
                                <td><span class="badge-soft">{{ $competition->standings_count }}</span></td>
                                <td>{!! $competition->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Inactive</span>' !!}</td>
                                <td class="text-end text-nowrap">
                                    <button class="btn btn-admin-outline btn-sm" data-bs-toggle="modal" data-bs-target="#competition{{ $competition->id }}"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.competitions.destroy', $competition) }}" method="POST" class="d-inline" data-confirm="Delete this competition? All standings linked to it will also be deleted.">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">No competitions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($competitions as $competition)
    <div class="modal fade" id="competition{{ $competition->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.competitions.update', $competition) }}" method="POST" class="modal-content form-admin">
                @csrf @method('PUT')
                <div class="modal-header"><h5 class="modal-title">Edit competition</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ $competition->name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ $competition->description }}</textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="competitionActive{{ $competition->id }}" @checked($competition->is_active)>
                        <label class="form-check-label" for="competitionActive{{ $competition->id }}">Active</label>
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
