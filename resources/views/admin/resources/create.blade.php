@extends('admin.layouts.app')

@section('page_title', 'Upload resource')
@section('page_subtitle', 'Add a downloadable document or external link')

@section('content')
<div class="page-head">
    <div><h1>Upload resource</h1><div class="sub">Documents, forms, policies and reports</div></div>
    <a href="{{ route('admin.resources.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to resources</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.resources._form')
</form>
@endsection
