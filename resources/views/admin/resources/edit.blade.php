@extends('admin.layouts.app')

@section('page_title', 'Edit resource')
@section('page_subtitle', $resource->title)

@section('content')
<div class="page-head">
    <div><h1>Edit resource</h1><div class="sub">Last updated {{ $resource->updated_at->diffForHumans() }}</div></div>
    <a href="{{ route('admin.resources.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.resources.update', $resource) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.resources._form')
</form>
@endsection
