@extends('admin.layouts.app')

@section('page_title', 'News articles')
@section('page_subtitle', 'Create, edit and publish club stories')

@section('content')
<div class="page-head">
    <div>
        <h1>News articles</h1>
        <div class="sub">{{ $articles->total() }} article{{ $articles->total() === 1 ? '' : 's' }} in total</div>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>New article</a>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.articles.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Title or summary">
            </div>
            <div class="col-md-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Sections</th>
                    <th>Published</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ media_url($article->featured_image, 'images/placeholder.svg') }}" alt="" class="rounded" style="width:64px;height:48px;object-fit:cover;">
                                <div>
                                    <div class="fw-semibold">{{ $article->title }}</div>
                                    <div class="text-muted small">{{ $article->author ?: 'Club desk' }} · {{ number_format($article->views) }} views</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-soft">{{ $article->category }}</span></td>
                        <td>
                            @if($article->is_published)
                                <span class="badge-soft"><i class="bi bi-check2 me-1"></i>Published</span>
                            @else
                                <span class="badge-muted">Draft</span>
                            @endif
                            @if($article->is_featured)<span class="badge-soft badge-warn ms-1">Featured</span>@endif
                        </td>
                        <td class="text-muted">{{ $article->sections_count }}</td>
                        <td class="text-muted small">{{ optional($article->published_at)->format('d M Y') ?: '—' }}</td>
                        <td class="text-end text-nowrap">
                            @if($article->is_published)
                                <a href="{{ route('news.show', $article) }}" target="_blank" rel="noopener" class="btn btn-admin-outline btn-sm" title="View"><i class="bi bi-eye"></i></a>
                            @endif
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-admin-outline btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline" data-confirm="Delete this article? This cannot be undone.">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No articles found. <a href="{{ route('admin.articles.create') }}">Create the first one</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $articles->links() }}</div>
@endsection
