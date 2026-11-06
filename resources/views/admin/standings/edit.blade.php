@extends('admin.layouts.app')

@section('page_title', 'Edit standing')
@section('page_subtitle', ($standing->club?->name ?: 'Club').' · '.($standing->competition?->name ?: 'Competition'))

@section('content')
<div class="page-head">
    <div><h1>Edit standing</h1><div class="sub">Last updated {{ $standing->updated_at->diffForHumans() }}</div></div>
    <a href="{{ route('admin.standings.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.standings.update', $standing) }}" method="POST" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.standings._form')
</form>
@endsection
