@extends('admin.layouts.app')

@section('page_title', 'Edit page')
@section('page_subtitle', $page->title)

@push('head')
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
@endpush

@section('content')
<div class="page-head">
    <div><h1>Edit page</h1><div class="sub">Last updated {{ $page->updated_at->diffForHumans() }}</div></div>
    <div class="d-flex gap-2">
        @if($page->is_published)
            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" rel="noopener" class="btn btn-admin-outline"><i class="bi bi-eye me-1"></i>View</a>
        @endif
        <a href="{{ route('admin.pages.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
    </div>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.pages._form')
</form>
@endsection

@push('scripts')
<script src="{{ asset('vendor/quill/quill.js') }}"></script>
@endpush
