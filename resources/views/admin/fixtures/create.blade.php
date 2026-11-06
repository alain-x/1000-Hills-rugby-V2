@extends('admin.layouts.app')

@section('page_title', 'New fixture')
@section('page_subtitle', 'Add a match to the calendar')

@section('content')
<div class="page-head">
    <div><h1>New fixture</h1><div class="sub">Schedule a match or record a result</div></div>
    <a href="{{ route('admin.fixtures.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to fixtures</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.fixtures.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.fixtures._form')
</form>
@endsection
