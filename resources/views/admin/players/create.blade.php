@extends('admin.layouts.app')

@section('page_title', 'Add player')
@section('page_subtitle', 'Create a squad profile')

@section('content')
<div class="page-head">
    <div><h1>Add player</h1><div class="sub">Profile, position and statistics</div></div>
    <a href="{{ route('admin.players.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to players</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.players.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.players._form')
</form>
@endsection
