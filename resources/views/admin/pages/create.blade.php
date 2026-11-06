@extends('admin.layouts.app')

@section('page_title', 'New page')
@section('page_subtitle', 'Create an editable content page')

@push('head')
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
@endpush

@section('content')
<div class="page-head">
    <div><h1>New page</h1><div class="sub">About, academy, foundation, community and more</div></div>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to pages</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.pages._form')
</form>
@endsection

@push('scripts')
<script src="{{ asset('vendor/quill/quill.js') }}"></script>
@endpush
