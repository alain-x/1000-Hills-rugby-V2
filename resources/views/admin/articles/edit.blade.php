@extends('admin.layouts.app')

@section('page_title', 'Edit article')
@section('page_subtitle', $article->title)

@push('head')
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
@endpush

@section('content')
<div class="page-head">
    <div>
        <h1>Edit article</h1>
        <div class="sub">Last updated {{ $article->updated_at->diffForHumans() }}</div>
    </div>
    <div class="d-flex gap-2">
        @if($article->is_published)
            <a href="{{ route('news.show', $article) }}" target="_blank" rel="noopener" class="btn btn-admin-outline"><i class="bi bi-eye me-1"></i>View</a>
        @endif
        <a href="{{ route('admin.articles.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
    </div>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.articles._form')
</form>
@endsection

@push('scripts')
<script src="{{ asset('vendor/quill/quill.js') }}"></script>
@endpush
