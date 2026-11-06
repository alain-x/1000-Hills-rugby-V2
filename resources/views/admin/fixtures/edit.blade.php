@extends('admin.layouts.app')

@section('page_title', 'Edit fixture')
@section('page_subtitle', $fixture->home_team.' v '.$fixture->away_team)

@section('content')
<div class="page-head">
    <div><h1>Edit fixture</h1><div class="sub">Last updated {{ $fixture->updated_at->diffForHumans() }}</div></div>
    <a href="{{ route('admin.fixtures.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.fixtures.update', $fixture) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.fixtures._form')
</form>
@endsection
