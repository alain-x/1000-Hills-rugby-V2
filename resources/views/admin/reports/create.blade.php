@extends('admin.layouts.app')

@section('page_title', 'New performance report')
@section('page_subtitle', 'Rate a player and write the coach report')

@section('content')
<div class="page-head">
    <div><h1>New performance report</h1><div class="sub">{{ $team?->name ?: 'Squad report' }}</div></div>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

@if(! $team)
    <div class="alert alert-warning">Your account is not assigned to a squad yet.</div>
@else
    <form action="{{ route('admin.reports.store') }}" method="POST" class="form-admin">
        @csrf
        @include('admin.reports._form')
    </form>
@endif
@endsection
