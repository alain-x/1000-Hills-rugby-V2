@extends('admin.layouts.app')

@section('page_title', 'Resources')
@section('page_subtitle', 'Policies, forms, reports and downloadable files')

@section('content')
<div class="page-head">
    <div>
        <h1>Resources</h1>
        <div class="sub">{{ $resources->total() }} file{{ $resources->total() === 1 ? '' : 's' }} available</div>
    </div>
    <a href="{{ route('admin.resources.create') }}" class="btn btn-admin-forest"><i class="bi bi-cloud-arrow-up me-1"></i>Upload resource</a>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.resources.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Resource title">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.resources.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Resource</th>
                    <th>Category</th>
                    <th>Year</th>
                    <th>Downloads</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resources as $resource)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <span class="rounded bg-light d-grid" style="width:44px;height:44px;place-items:center;"><i class="bi bi-file-earmark-text text-muted"></i></span>
                                <div>
                                    <div class="fw-semibold">{{ $resource->title }}</div>
                                    <div class="text-muted small text-truncate" style="max-width:380px;">{{ $resource->description ?: ($resource->external_url ?: 'Uploaded file') }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-soft">{{ $resource->category ?: 'General' }}</span></td>
                        <td class="text-muted">{{ $resource->year ?: '—' }}</td>
                        <td class="text-muted">{{ number_format($resource->downloads) }}</td>
                        <td>{!! $resource->is_published ? '<span class="badge-soft">Published</span>' : '<span class="badge-muted">Draft</span>' !!}</td>
                        <td class="text-end text-nowrap">
                            @if($resource->is_published)
                                <a href="{{ route('resources.download', $resource) }}" target="_blank" rel="noopener" class="btn btn-admin-outline btn-sm" title="Open"><i class="bi bi-box-arrow-up-right"></i></a>
                            @endif
                            <a href="{{ route('admin.resources.edit', $resource) }}" class="btn btn-admin-outline btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.resources.destroy', $resource) }}" method="POST" class="d-inline" data-confirm="Delete this resource? The file will also be removed.">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No resources uploaded yet. <a href="{{ route('admin.resources.create') }}">Upload the first file</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $resources->links() }}</div>
@endsection
