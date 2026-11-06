@extends('admin.layouts.app')

@section('page_title', 'Website pages')
@section('page_subtitle', 'Manage the editable content pages of the public site')

@section('content')
<div class="page-head">
    <div>
        <h1>Website pages</h1>
        <div class="sub">{{ $pages->total() }} page{{ $pages->total() === 1 ? '' : 's' }} available</div>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>New page</a>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Updated</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($page->hero_image)
                                    <img src="{{ media_url($page->hero_image) }}" alt="" class="rounded" style="width:64px;height:48px;object-fit:cover;">
                                @else
                                    <span class="rounded bg-light d-grid" style="width:64px;height:48px;place-items:center;"><i class="bi bi-file-earmark-text text-muted"></i></span>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $page->title }}</div>
                                    <div class="text-muted small">{{ $page->subtitle ?: 'No subtitle' }}</div>
                                </div>
                            </div>
                        </td>
                        <td><code>/{{ $page->slug }}</code></td>
                        <td>{!! $page->is_published ? '<span class="badge-soft">Published</span>' : '<span class="badge-muted">Draft</span>' !!}</td>
                        <td class="text-muted">{{ $page->sort_order }}</td>
                        <td class="text-muted small">{{ $page->updated_at->format('d M Y') }}</td>
                        <td class="text-end text-nowrap">
                            @if($page->is_published)
                                <a href="{{ route('pages.show', $page->slug) }}" target="_blank" rel="noopener" class="btn btn-admin-outline btn-sm" title="View"><i class="bi bi-eye"></i></a>
                            @endif
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-admin-outline btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" data-confirm="Delete this page? This cannot be undone.">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No pages created yet. <a href="{{ route('admin.pages.create') }}">Create the first page</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $pages->links() }}</div>
@endsection
