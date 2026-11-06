@extends('admin.layouts.app')

@section('page_title', 'Edit team')
@section('page_subtitle', $team->name)

@section('content')
<div class="page-head">
    <div><h1>Edit team</h1><div class="sub">Last updated {{ $team->updated_at->diffForHumans() }}</div></div>
    <div class="d-flex gap-2">
        @if($team->is_active)
            <a href="{{ route('teams.show', $team) }}" target="_blank" rel="noopener" class="btn btn-admin-outline"><i class="bi bi-eye me-1"></i>View</a>
        @endif
        <a href="{{ route('admin.teams.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
    </div>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.teams.update', $team) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.teams._form')
</form>
@endsection
