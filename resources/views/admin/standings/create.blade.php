@extends('admin.layouts.app')

@section('page_title', 'Add standing')
@section('page_subtitle', 'Add a club row to a league table')

@section('content')
<div class="page-head">
    <div><h1>Add standing</h1><div class="sub">Competition, season and match statistics</div></div>
    <a href="{{ route('admin.standings.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to standings</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.standings.store') }}" method="POST" class="form-admin">
    @csrf
    @include('admin.standings._form')
</form>
@endsection
