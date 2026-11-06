@extends('admin.layouts.app')

@section('page_title', 'New team')
@section('page_subtitle', 'Add a squad to the club')

@section('content')
<div class="page-head">
    <div><h1>New team</h1><div class="sub">Senior or academy squad</div></div>
    <a href="{{ route('admin.teams.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to teams</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.teams._form')
</form>
@endsection
