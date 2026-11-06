@extends('admin.layouts.app')

@section('page_title', 'New article')
@section('page_subtitle', 'Share a story from the club')

@push('head')
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
@endpush

@section('content')
<div class="page-head">
    <div>
        <h1>New article</h1>
        <div class="sub">Draft a news story, match report or club update</div>
    </div>
    <a href="{{ route('admin.articles.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to articles</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.articles._form')
</form>
@endsection

@push('scripts')
<script src="{{ asset('vendor/quill/quill.js') }}"></script>
@endpush
