@extends('admin.layouts.app')

@section('page_title', 'Edit session')
@section('page_subtitle', $session->title)

@section('content')
<div class="page-head">
    <div><h1>Edit session</h1><div class="sub">{{ $session->team->name ?? 'Squad' }}</div></div>
    <a href="{{ route('admin.sessions.show', $session) }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>
@include('admin.partials.errors')
<form action="{{ route('admin.sessions.update', $session) }}" method="POST" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.sessions._form')
</form>
@endsection
