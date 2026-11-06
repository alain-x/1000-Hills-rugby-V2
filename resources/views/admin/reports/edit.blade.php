@extends('admin.layouts.app')

@section('page_title', 'Edit performance report')
@section('page_subtitle', $report->player->name)

@section('content')
<div class="page-head">
    <div><h1>Edit report</h1><div class="sub">{{ $report->player->name }}</div></div>
    <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.reports.update', $report) }}" method="POST" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.reports._form')
</form>
@endsection
