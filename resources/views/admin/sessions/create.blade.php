@extends('admin.layouts.app')

@section('page_title', 'New session')
@section('page_subtitle', 'Training, match, gym, recovery, video or meeting')

@section('content')
<div class="page-head">
    <div><h1>New session</h1><div class="sub">The squad coach records attendance after this is saved.</div></div>
    <a href="{{ route('admin.sessions.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>
@include('admin.partials.errors')
<form action="{{ route('admin.sessions.store') }}" method="POST" class="form-admin">
    @csrf
    @include('admin.sessions._form')
</form>
@endsection
