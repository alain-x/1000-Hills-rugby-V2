@extends('admin.layouts.app')

@section('page_title', 'Clubs')
@section('page_subtitle', 'Opponent clubs used in league tables')

@section('content')
<div class="page-head">
    <div><h1>Clubs</h1><div class="sub">{{ $clubs->count() }} club{{ $clubs->count() === 1 ? '' : 's' }}</div></div>
</div>

@include('admin.partials.errors')

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Add club</h5></div>
            <div class="card-panel-body">
                <form action="{{ route('admin.clubs.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Club name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="logo">Club logo</label>
                        <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                    <button class="btn btn-admin-forest w-100" type="submit"><i class="bi bi-plus-lg me-1"></i>Add club</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">All clubs</h5></div>
            <div class="table-responsive">
                <table class="table table-admin align-middle">
                    <thead><tr><th>Club</th><th>Slug</th><th>Standings rows</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse($clubs as $club)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ media_url($club->logo, 'images/placeholder.svg') }}" alt="" class="rounded" style="width:30px;height:30px;object-fit:contain;">
                                        <span class="fw-semibold">{{ $club->name }}</span>
                                    </div>
                                </td>
                                <td><code>{{ $club->slug }}</code></td>
                                <td><span class="badge-soft">{{ $club->standings_count }}</span></td>
                                <td>{!! $club->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Inactive</span>' !!}</td>
                                <td class="text-end text-nowrap">
                                    <button class="btn btn-admin-outline btn-sm" data-bs-toggle="modal" data-bs-target="#club{{ $club->id }}"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.clubs.destroy', $club) }}" method="POST" class="d-inline" data-confirm="Delete this club? Linked standings will also be deleted.">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">No clubs yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($clubs as $club)
    <div class="modal fade" id="club{{ $club->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.clubs.update', $club) }}" method="POST" enctype="multipart/form-data" class="modal-content form-admin">
                @csrf @method('PUT')
                <div class="modal-header"><h5 class="modal-title">Edit club</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ $club->name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Replace logo</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="clubActive{{ $club->id }}" @checked($club->is_active)>
                        <label class="form-check-label" for="clubActive{{ $club->id }}">Active</label>
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
